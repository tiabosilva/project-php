<?php

namespace App\DataFixtures;

use App\Entity\CollectionVoitures;
use App\Entity\Voiture;
use App\Entity\Galerie;
use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        // -------------------------------------------------------
        // CREATE INTERNAL USERS FOR DEFAULT DATA
        // (User1 and User2 from UserFixtures stay empty)
        // -------------------------------------------------------
        
        $owner1 = new Member();
        $owner1->setEmail("ownerVintage@local");
        $owner1->setPassword($this->hasher->hashPassword($owner1, "password"));
        $owner1->setRoles(["ROLE_USER"]);
        $manager->persist($owner1);
        
        $owner2 = new Member();
        $owner2->setEmail("ownerSupercars@local");
        $owner2->setPassword($this->hasher->hashPassword($owner2, "password"));
        $owner2->setRoles(["ROLE_USER"]);
        $manager->persist($owner2);
        
        $owner3 = new Member();
        $owner3->setEmail("ownerMuscle@local");
        $owner3->setPassword($this->hasher->hashPassword($owner3, "password"));
        $owner3->setRoles(["ROLE_USER"]);
        $manager->persist($owner3);
        
        // -------------------------------------------------------
        // COLLECTIONS (assigned ONLY to internal fixture users)
        // -------------------------------------------------------
        
        $c1 = (new CollectionVoitures())
        ->setName("Vintage")
        ->setDescription("Vintage European Cars")
        ->setYearCreated(1960);
        $manager->persist($c1);
        $owner1->setCollectionVoitures($c1);
        
        $c2 = (new CollectionVoitures())
        ->setName("Exotics")
        ->setDescription("Exotic Sports Cars")
        ->setYearCreated(2010);
        $manager->persist($c2);
        $owner2->setCollectionVoitures($c2);
        
        $c3 = (new CollectionVoitures())
        ->setName("Muscle")
        ->setDescription("Classic American Muscle Cars")
        ->setYearCreated(1970);
        $manager->persist($c3);
        $owner3->setCollectionVoitures($c3);
        
        // -------------------------------------------------------
        // CARS
        // -------------------------------------------------------
        
        $cars = [];
        
        $cars[] = (new Voiture())->setModele('250 GTO')->setMarque('Ferrari')->setAnnee('1962')->setCollectionVoitures($c1);
        $cars[] = (new Voiture())->setModele('E-Type')->setMarque('Jaguar')->setAnnee('1961')->setCollectionVoitures($c1);
        
        $cars[] = (new Voiture())->setModele('Aventador')->setMarque('Lamborghini')->setAnnee('2015')->setCollectionVoitures($c2);
        $cars[] = (new Voiture())->setModele('Huayra')->setMarque('Pagani')->setAnnee('2017')->setCollectionVoitures($c2);
        
        $cars[] = (new Voiture())->setModele('Mustang GT')->setMarque('Ford')->setAnnee('1969')->setCollectionVoitures($c3);
        $cars[] = (new Voiture())->setModele('Camaro SS')->setMarque('Chevrolet')->setAnnee('1970')->setCollectionVoitures($c3);
        
        foreach ($cars as $car) {
            $manager->persist($car);
        }
        
        // -------------------------------------------------------
        // GALERIES (owned only by internal fixture users)
        // -------------------------------------------------------
        
        $gal1 = (new Galerie())
        ->setDescription("Galerie Vintage")
        ->setPubliee(true)
        ->setCreateur($owner1);
        $gal1->addVoiture($cars[0])->addVoiture($cars[1]);
        $manager->persist($gal1);
        
        $gal2 = (new Galerie())
        ->setDescription("Supercars Showcase")
        ->setPubliee(true)
        ->setCreateur($owner2);
        $gal2->addVoiture($cars[2])->addVoiture($cars[3]);
        $manager->persist($gal2);
        
        $gal3 = (new Galerie())
        ->setDescription("Muscle Legends")
        ->setPubliee(false)
        ->setCreateur($owner3);
        $gal3->addVoiture($cars[4])->addVoiture($cars[5]);
        $manager->persist($gal3);
        
        $manager->flush();
    }
}
