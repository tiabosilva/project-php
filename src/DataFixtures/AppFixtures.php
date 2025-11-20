<?php

namespace App\DataFixtures;

use App\Entity\CollectionVoitures;
use App\Entity\Voiture;
use App\Entity\Galerie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // === COLLECTIONS ===
        $collection1 = new CollectionVoitures();
        $collection1->setDescription('Vintage European Cars');
        $manager->persist($collection1);
        
        $collection2 = new CollectionVoitures();
        $collection2->setDescription('Exotic Sports Cars');
        $manager->persist($collection2);
        
        $collection3 = new CollectionVoitures();
        $collection3->setDescription('Classic American Muscle');
        $manager->persist($collection3);
        
        // === VOITURES ===
        $voitures = [];
        
        $voitures[] = (new Voiture())
        ->setModele('250 GTO')
        ->setMarque('Ferrari')
        ->setAnnee('1962')
        ->setCollectionVoitures($collection1);
        $manager->persist(end($voitures));
        
        $voitures[] = (new Voiture())
        ->setModele('E-Type')
        ->setMarque('Jaguar')
        ->setAnnee('1961')
        ->setCollectionVoitures($collection1);
        $manager->persist(end($voitures));
        
        $voitures[] = (new Voiture())
        ->setModele('Aventador')
        ->setMarque('Lamborghini')
        ->setAnnee('2015')
        ->setCollectionVoitures($collection2);
        $manager->persist(end($voitures));
        
        $voitures[] = (new Voiture())
        ->setModele('Huayra')
        ->setMarque('Pagani')
        ->setAnnee('2017')
        ->setCollectionVoitures($collection2);
        $manager->persist(end($voitures));
        
        $voitures[] = (new Voiture())
        ->setModele('Mustang GT')
        ->setMarque('Ford')
        ->setAnnee('1969')
        ->setCollectionVoitures($collection3);
        $manager->persist(end($voitures));
        
        $voitures[] = (new Voiture())
        ->setModele('Camaro SS')
        ->setMarque('Chevrolet')
        ->setAnnee('1970')
        ->setCollectionVoitures($collection3);
        $manager->persist(end($voitures));
        
        // === GALERIES ===
        $galerie1 = new Galerie();
        $galerie1->setDescription('Galerie Vintage')
        ->setPubliee(true);
        $galerie1->addVoiture($voitures[0]);
        $galerie1->addVoiture($voitures[1]);
        $manager->persist($galerie1);
        
        $galerie2 = new Galerie();
        $galerie2->setDescription('Supercars Showcase')
        ->setPubliee(true);
        $galerie2->addVoiture($voitures[2]);
        $galerie2->addVoiture($voitures[3]);
        $manager->persist($galerie2);
        
        $galerie3 = new Galerie();
        $galerie3->setDescription('Muscle Legends')
        ->setPubliee(false);
        $galerie3->addVoiture($voitures[4]);
        $galerie3->addVoiture($voitures[5]);
        $manager->persist($galerie3);
        
        // === FLUSH ===
        $manager->flush();
    }
}
