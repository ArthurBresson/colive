<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Utilisateur;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/messages')]
class MessageController extends AbstractController
{
    #[Route('/', name: 'app_messages_list')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('message/index.html.twig', [
            'conversations' => $user->getConversations(),
        ]);
    }

    #[Route('/{id}', name: 'app_message_show')]
    public function show(Conversation $conversation, Request $request, EntityManagerInterface $em): Response
    {
        if (!$conversation->getParticipants()->contains($this->getUser())) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette discussion.");
        }

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $message->setConversation($conversation);
            $message->setCreatedAt(new \DateTimeImmutable());

            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('app_message_show', ['id' => $conversation->getId()]);
        }

        return $this->render('message/show.html.twig', [
            'conversation' => $conversation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/start/{id}', name: 'app_message_start')]
    public function start(Utilisateur $targetUser, EntityManagerInterface $em): Response
    {
        $currentUser = $this->getUser();

        if (!$currentUser || $currentUser === $targetUser) {
            return $this->redirectToRoute('app_messages_list');
        }

        $existingConversation = null;
        foreach ($currentUser->getConversations() as $conv) {
            if ($conv->getParticipants()->contains($targetUser)) {
                $existingConversation = $conv;
                break;
            }
        }
        if (!$existingConversation) {
            $existingConversation = new Conversation();
            $existingConversation->addParticipant($currentUser);
            $existingConversation->addParticipant($targetUser);

            $em->persist($existingConversation);
            $em->flush();
        }

        return $this->redirectToRoute('app_message_show', ['id' => $existingConversation->getId()]);
    }
}
