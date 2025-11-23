<?php

namespace App\Controller;

use App\Entity\CollectionVoitures;
use App\Form\CollectionVoituresType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectionVoituresController extends AbstractController
{
    #[Route('/collection/voitures', name: 'collection_voitures_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(CollectionVoitures::class);
        
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }
        
        if ($this->isGranted('ROLE_ADMIN')) {
            // Admin sees all collections
            $collections = $repo->findAll();
        } else {
            // Normal user sees only his own
            $user = $this->getUser();
            $collections = $user->getCollectionVoitures() ? [$user->getCollectionVoitures()] : [];
        }
        
        return $this->render('collection_voitures/index.html.twig', [
            'collections' => $collections,
        ]);
    }
    
    
    #[Route('/collection/new', name: 'collection_voitures_new')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $collection = new CollectionVoitures();
        
        $form = $this->createForm(CollectionVoituresType::class, $collection);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $collection->setMember($this->getUser());
            
            $em->persist($collection);
            $em->flush();
            
            return $this->redirectToRoute('collection_voitures_list');
        }
        
        return $this->render('collection_voitures/new.html.twig', [
            'form' => $form,
        ]);
    }
    
    #[Route('/collection/voitures/{id}', name: 'collection_voitures_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $collection = $doctrine->getRepository(CollectionVoitures::class)->find($id);
        
        if (!$collection) {
            throw $this->createNotFoundException('Collection introuvable.');
        }
        
        if (!$this->isGranted('ROLE_ADMIN')) {
            $user = $this->getUser();
            if (!$user || $user->getCollectionVoitures() !== $collection) {
                throw $this->createAccessDeniedException(
                    "Vous ne pouvez pas accéder à cette collection."
                    );
            }
        }
        
        return $this->render('collection_voitures/show.html.twig', [
            'collection' => $collection,
        ]);
    }
}
