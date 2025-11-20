<?php

namespace App\Controller;

use App\Entity\CollectionVoitures;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectionVoituresController extends AbstractController
{
    #[Route('/collection/voitures', name: 'collection_voitures_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(CollectionVoitures::class);
        
        // ADMIN → sees all collections
        if ($this->isGranted('ROLE_ADMIN')) {
            $collections = $repo->findAll();
        }
        else {
            // USER → sees only his collection
            $user = $this->getUser();
            
            if (!$user || !$user->getCollectionVoitures()) {
                // user not logged or no collection → show nothing
                $collections = [];
            } else {
                $collections = [$user->getCollectionVoitures()];
            }
        }
        
        return $this->render('collection_voitures/index.html.twig', [
            'collections' => $collections,
        ]);
    }
    
    
    #[Route('/collection/voitures/{id}', name: 'collection_voitures_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $collection = $doctrine->getRepository(CollectionVoitures::class)->find($id);
        
        if (!$collection) {
            throw $this->createNotFoundException('Collection introuvable.');
        }
        
        // ADMIN → unlimited access
        if (!$this->isGranted('ROLE_ADMIN')) {
            
            $user = $this->getUser();
            
            // USER must own the collection
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
