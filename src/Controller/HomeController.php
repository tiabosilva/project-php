<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // 🔥 Si l’utilisateur est ADMIN → on le renvoie directement au Dashboard admin
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin'); // ton route admin existant
        }
        
        // Sinon un user normal voit la page d’accueil classique
        return $this->render('home/index.html.twig');
    }
}
