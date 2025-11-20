<?php

namespace App\Controller;

use App\Entity\CollectionVoitures;
use App\Entity\Galerie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
        // FORCE LOGIN
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        $user = $this->getUser();
        
        // USER COLLECTION (should be only 1)
        $collection = $user->getCollectionVoitures();
        
        // USER GALERIES
        $userGaleries = $em->getRepository(Galerie::class)->findBy([
            'createur' => $user
        ]);
        
        // PUBLIC GALERIES (not by this user)
        $publicGaleries = $em->getRepository(Galerie::class)->findBy([
            'publiee' => true
        ]);
        
        return $this->render('home/index.html.twig', [
            'collection'      => $collection,
            'user_galeries'   => $userGaleries,
            'public_galeries' => $publicGaleries,
        ]);
    }
}
