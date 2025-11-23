<?php

namespace App\Controller;

use App\Entity\CollectionVoitures;
use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureCreateController extends AbstractController
{
    #[Route('/collection/voitures/{id}/voiture/new', name: 'voiture_new_for_collection')]
    public function new(
        int $id,
        Request $request,
        ManagerRegistry $doctrine,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $collection = $doctrine->getRepository(CollectionVoitures::class)->find($id);

        if (!$collection) {
            throw $this->createNotFoundException('Collection introuvable.');
        }

        if (!$this->isGranted('ROLE_ADMIN')) {
            $user = $this->getUser();
            if (!$user || $user->getCollectionVoitures() !== $collection) {
                throw $this->createAccessDeniedException(
                    "Vous ne pouvez pas ajouter de voiture à cette collection."
                );
            }
        }

        $voiture = new Voiture();
        $voiture->setCollectionVoitures($collection);

        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($voiture);
            $em->flush();

            return $this->redirectToRoute('collection_voitures_show', [
                'id' => $collection->getId(),
            ]);
        }

        return $this->render('voiture/new.html.twig', [
            'collection' => $collection,
            'form' => $form,
        ]);
    }
}
