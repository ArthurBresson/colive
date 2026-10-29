<?php

namespace App\Controller;

use App\Entity\Espace;
use App\Entity\PhotoEspace;
use App\Form\PhotoEspaceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PhotoEspaceController extends AbstractController
{
    #[Route('/espace/{id}/ajouter-photo', name: 'app_photo_add')]
    public function add(Espace $espace, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->getUser() !== $espace->getOwner() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException("Vous n'êtes pas le propriétaire de cette annonce.");
        }

        $photo = new PhotoEspace();
        $form = $this->createForm(PhotoEspaceType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('img')->getData();

            if ($file) {
                $photo->setImg(file_get_contents($file->getPathname()));
                $photo->setImgType($file->getClientMimeType());
                $photo->setNom($file->getClientOriginalName());
                $photo->setEspace($espace);

                $em->persist($photo);
                $em->flush();

                $this->addFlash('success', 'La photo a été ajoutée avec succès !');

                return $this->redirectToRoute('app_espace');
            }
        }

        return $this->render('photo_espace/add.html.twig', [
            'form' => $form->createView(),
            'espace' => $espace,
        ]);
    }

    #[Route('/photo/{id}', name: 'app_photo')]
    public function show(PhotoEspace $photo): Response
    {
        $data = $photo->getImg();

        if (is_resource($data)) {
            $data = stream_get_contents($data);
        }

        return new Response($data, 200, [
            'Content-Type' => $photo->getImgType(),
            'Content-Disposition' => 'inline',
        ]);
    }
}
