<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Espace;
use App\Form\AvisType;
use App\Form\EspaceType;
use App\Repository\EspaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class EspaceController extends AbstractController
{
    #[Route('/espace', name: 'app_espace')]
    public function index(
        EspaceRepository $espaceRepo,
        #[MapQueryParameter] string $search = '',
        #[MapQueryParameter] ?int $maxPrice = null,
        #[MapQueryParameter] ?int $minSurface = null,
        #[MapQueryParameter] int $page = 1,
    ): Response {
        $limit = 18;
        $offset = ($page - 1) * $limit;

        $listEspace = $espaceRepo->search($search, $maxPrice, $minSurface, $limit, $offset);
        $listEspace = iterator_to_array($listEspace);

        return $this->render('espace/index.html.twig', [
            'espaces' => $listEspace,
            'page' => $page,
            'limit' => $limit,
        ]);
    }

    #[Route('/espace/{id}', name: 'espace', requirements: ['id' => '\d+'])]
    public function show(Espace $espace, Request $request, EntityManagerInterface $em): Response
    {
        // si non connecté, pas de formulaire pour un commentaire
        if (!$this->getUser()) {
            return $this->render('espace/show.html.twig', ['espace' => $espace]);
        }

        $avis = new Avis();

        $avis->setEspaceAvis($espace);
        $avis->setUserAvis($this->getUser());

        $form = $this->createForm(AvisType::class, $avis);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($avis);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès !');

            return $this->redirectToRoute('espace', ['id' => $espace->getId()]);
        }

        return $this->render('espace/show.html.twig', ['espace' => $espace, 'form' => $form->createView()]);
    }

    #[Route('/espace/perso', name: 'app_espace_user', requirements: ['id' => '\d+'])]
    public function indexUser(EspaceRepository $espaceRepo, #[MapQueryParameter] int $page = 1): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $limit = 18;
        $offset = ($page - 1) * $limit;
        $user = $this->getUser();

        $listEspace = $espaceRepo->searchByUser($user, $limit, $offset);

        return $this->render('espace/indexuser.html.twig', ['espaces' => $listEspace, 'page' => $page, 'limit' => $limit]);
    }

    #[Route('/espace/ajouter', name: 'app_espace_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $espace = new Espace();

        $espace->setOwner($this->getUser());
        $espace->setDatePubliEsp(new \DateTime());

        $form = $this->createForm(EspaceType::class, $espace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($espace);
            $em->flush();

            $this->addFlash('success', 'Votre logement a été ajouté avec succès !');

            return $this->redirectToRoute('espace', ['id' => $espace->getId()]);
        }

        return $this->render('espace/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/espace/{id}/modifier', name: 'app_espace_edit', requirements: ['id' => '\d+'])]
    public function edit(Espace $espace, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->getUser() !== $espace->getOwner() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException("Vous n'êtes pas le propriétaire de cette annonce.");
        }

        $form = $this->createForm(EspaceType::class, $espace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Logement modifié avec succès !');

            return $this->redirectToRoute('espace', ['id' => $espace->getId()]);
        }

        return $this->render('espace/modifier.html.twig', ['form' => $form->createView(), 'espace' => $espace]);
    }

    #[Route('/espace/{id}/supprimer', name: 'app_espace_delete', requirements: ['id' => '\d+'])]
    public function delete(Espace $espace, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->getUser() !== $espace->getOwner() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException("Vous n'êtes pas le propriétaire de cette annonce.");
        }

        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class, ['label' => 'Supprimer'])
            ->add('cancel', SubmitType::class, ['label' => 'Annuler'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $em->remove($espace);
                $em->flush();

                $this->addFlash('success', 'Logement supprimé avec succès !');

                return $this->redirectToRoute('app_espace');
            }
            if ($form->get('cancel')->isClicked()) {
                return $this->redirectToRoute('espace', ['id' => $espace->getId()]);
            }
        }

        return $this->render('espace/delete.html.twig', ['form' => $form->createView(), 'espace' => $espace]);
    }
}
