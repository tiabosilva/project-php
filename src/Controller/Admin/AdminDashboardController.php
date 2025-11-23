<?php

namespace App\Controller\Admin;

use App\Entity\CollectionVoitures;
use App\Entity\Galerie;
use App\Entity\Member;
use App\Entity\Voiture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminDashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('MyCars Admin');
    }
    
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        
        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Members', 'fa fa-user', Member::class);
        
        yield MenuItem::section('Inventaires');
        yield MenuItem::linkToCrud('Collections', 'fa fa-box', CollectionVoitures::class);
        yield MenuItem::linkToCrud('Voitures', 'fa fa-car', Voiture::class);
        
        yield MenuItem::section('Galeries');
        yield MenuItem::linkToCrud('Galeries', 'fa fa-images', Galerie::class);
    }
    
    
    
}
