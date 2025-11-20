<?php

namespace App\Controller;

use App\Entity\CollectionVoitures;
use App\Form\CollectionVoituresType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectionCreateController extends AbstractController
{
    #[Route('/collection/new', name: 'collection_create')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $user = $this->getUser();
        
        if ($user->getCollectionVoitures()) {
            return $this->redirectToRoute('collection_voitures_show', [
                'id' => $user->getCollectionVoitures()->getId()
            ]);
        }
        
        $collection = new CollectionVoitures();
        $collection->setMember($user);
        
        $form = $this->createForm(CollectionVoituresType::class, $collection);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($collection);
            $em->flush();
            
            return $this->redirectToRoute('collection_voitures_show', [
                'id' => $collection->getId()
            ]);
        }
        
        return $this->render('collection_voitures/new.html.twig', [
            'form' => $form,
        ]);
    }
}
