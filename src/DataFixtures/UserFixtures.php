<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        // ADMIN
        $admin = new Member();
        $admin->setEmail("admin@local");
        $admin->setPassword($this->hasher->hashPassword($admin, "admin123"));
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);
        
        // USER 1
        $user1 = new Member();
        $user1->setEmail("user1@local");
        $user1->setPassword($this->hasher->hashPassword($user1, "user123"));
        $user1->setRoles(["ROLE_USER"]);
        $manager->persist($user1);
        
        // USER 2
        $user2 = new Member();
        $user2->setEmail("user2@local");
        $user2->setPassword($this->hasher->hashPassword($user2, "user123"));
        $user2->setRoles(["ROLE_USER"]);
        $manager->persist($user2);
        
        $manager->flush();
    }
}
