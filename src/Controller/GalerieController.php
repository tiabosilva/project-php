<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Repository\GalerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/galerie')]
final class GalerieController extends AbstractController
{
    #[Route(name: 'app_galerie_index', methods: ['GET'])]
    public function index(GalerieRepository $galerieRepository): Response
    {
        $user = $this->getUser();
        
        // ADMIN: sees everything
        if ($this->isGranted('ROLE_ADMIN')) {
            $galeries = $galerieRepository->findAll();
        }
        // NORMAL USER: sees (his own galleries OR public galleries)
        else {
            $galeries = $galerieRepository->createQueryBuilder('g')
            ->where('g.publiee = :pub')
            ->orWhere('g.createur = :user')
            ->setParameter('pub', true)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
        }
        
        return $this->render('galerie/index.html.twig', [
            'galeries' => $galeries,
        ]);
    }
    
    
    #[Route('/new', name: 'app_galerie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $galerie = new Galerie();
        $galerie->setCreateur($this->getUser()); // important
        
        $form = $this->createForm(GalerieType::class, $galerie, [
            'user' => $this->getUser(),
        ]);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($galerie);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_galerie_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('galerie/new.html.twig', [
            'galerie' => $galerie,
            'form'    => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_galerie_show', methods: ['GET'])]
    public function show(Galerie $galerie): Response
    {
        // if not published, only creator or admin can see it
        if (!$galerie->isPubliee() && !$this->isGranted('ROLE_ADMIN')) {
            $member = $this->getUser();
            if (!$member || $member !== $galerie->getCreateur()) {
                throw $this->createAccessDeniedException("Vous ne pouvez pas accéder à cette galerie.");
            }
        }
        
        return $this->render('galerie/show.html.twig', [
            'galerie' => $galerie,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_galerie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Galerie $galerie, EntityManagerInterface $entityManager): Response
    {
        $member = $this->getUser();
        if (!$this->isGranted('ROLE_ADMIN') && (!$member || $member !== $galerie->getCreateur())) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas modifier cette galerie.");
        }
        
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            return $this->redirectToRoute('app_galerie_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('galerie/edit.html.twig', [
            'galerie' => $galerie,
            'form'    => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_galerie_delete', methods: ['POST'])]
    public function delete(Request $request, Galerie $galerie, EntityManagerInterface $entityManager): Response
    {
        $member = $this->getUser();
        if (!$this->isGranted('ROLE_ADMIN') && (!$member || $member !== $galerie->getCreateur())) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas supprimer cette galerie.");
        }
        
        if ($this->isCsrfTokenValid('delete'.$galerie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($galerie);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_galerie_index', [], Response::HTTP_SEE_OTHER);
    }
}
