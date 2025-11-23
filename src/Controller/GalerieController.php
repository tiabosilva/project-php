<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Repository\GalerieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/galerie')]
class GalerieController extends AbstractController
{
    #[Route('/', name: 'app_galerie_index')]
    public function index(GalerieRepository $repo): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_galerie_mine');
        }
        
        return $this->render('galerie/index.html.twig', [
            'title' => 'Toutes les galeries (Admin)',
            'galeries' => $repo->findAll(),
        ]);
    }
    
    #[Route('/public', name: 'app_galerie_public')]
    public function public(GalerieRepository $repo): Response
    {
        return $this->render('galerie/index.html.twig', [
            'title' => 'Galeries publiques',
            'galeries' => $repo->findBy(['publiee' => true]),
        ]);
    }
    
    #[Route('/mine', name: 'app_galerie_mine')]
    public function mine(GalerieRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        return $this->render('galerie/index.html.twig', [
            'title' => 'Mes galeries',
            'galeries' => $repo->findBy(['createur' => $this->getUser()]),
        ]);
    }
    
    
    #[Route('/public', name: 'app_galerie_public', methods: ['GET'])]
    public function publicGalleries(GalerieRepository $galerieRepository): Response
    {
        return $this->render('galerie/index.html.twig', [
            'galeries' => $galerieRepository->findBy(['publiee' => true]),
            'title' => 'Galeries publiques',
        ]);
    }
    
    #[Route('/mine', name: 'app_galerie_mine', methods: ['GET'])]
    public function myGalleries(GalerieRepository $galerieRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $user = $this->getUser();
        
        return $this->render('galerie/index.html.twig', [
            'galeries' => $galerieRepository->findBy(['createur' => $user]),
            'title' => 'Mes galeries',
        ]);
    }
    
    #[Route('/new', name: 'app_galerie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $collection = $user?->getCollectionVoitures();
        
        if (!$collection || $collection->getVoitures()->isEmpty()) {
            $this->addFlash('warning', "Vous devez d'abord ajouter des voitures à votre collection.");
            return $this->redirectToRoute('collection_voitures_list');
        }
        
        $galerie = new Galerie();
        $galerie->setCreateur($user);
        
        $form = $this->createForm(GalerieType::class, $galerie, [
            'voitures' => $collection->getVoitures(),
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($galerie);
            $em->flush();
            return $this->redirectToRoute('app_galerie_mine');
        }
        
        return $this->render('galerie/new.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_galerie_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Galerie $galerie,
        EntityManagerInterface $em
        ): Response {
            $this->denyAccessUnlessGranted('ROLE_USER');
            
            if (
                !$this->isGranted('ROLE_ADMIN') &&
                $galerie->getCreateur() !== $this->getUser()
                ) {
                    throw $this->createAccessDeniedException("Vous ne pouvez pas modifier cette galerie.");
                }
                
                $collection = $this->getUser()->getCollectionVoitures();
                
                $form = $this->createForm(GalerieType::class, $galerie, [
                    'voitures' => $collection->getVoitures(),
                ]);
                $form->handleRequest($request);
                
                if ($form->isSubmitted() && $form->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_galerie_mine');
                }
                
                return $this->render('galerie/edit.html.twig', [
                    'galerie' => $galerie,
                    'form' => $form,
                ]);
    }
    
    #[Route('/{id}', name: 'app_galerie_show', methods: ['GET'])]
    public function show(Galerie $galerie): Response
    {
        if (
            !$galerie->isPubliee() &&
            $galerie->getCreateur() !== $this->getUser() &&
            !$this->isGranted('ROLE_ADMIN')
            ) {
                throw $this->createAccessDeniedException("Cette galerie est privée.");
            }
            
            return $this->render('galerie/show.html.twig', [
                'galerie' => $galerie,
            ]);
    }
    #[Route('/galerie/{id}/delete', name: 'app_galerie_delete', methods: ['POST'])]
    public function delete(Request $request, Galerie $galerie, EntityManagerInterface $em): Response
    {
        // Sécurité : seul le créateur OU admin peut supprimer
        if ($galerie->getCreateur() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }
        
        if ($this->isCsrfTokenValid('delete'.$galerie->getId(), $request->request->get('_token'))) {
            $em->remove($galerie);
            $em->flush();
        }
        
        return $this->redirectToRoute('app_galerie_mine');
    }
    
}
