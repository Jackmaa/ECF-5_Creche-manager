<?php
// src/DataFixtures/UserFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture {
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {
    }
    public function load(ObjectManager $manager): void 
    {
        $admin = new User();
        $admin->setEmail('admin@creche.local');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $manager->persist($admin);

        $parent = new User();
        $parent->setEmail('parent@creche.local');
        $parent->setRoles(['ROLE_PARENT']);
        $parent->setPassword($this->passwordHasher->hashPassword($parent, 'parent'));
        $manager->persist($parent);

        $encadrant = new User();
        $encadrant->setEmail('encadrant@creche.local');
        $encadrant->setRoles(['ROLE_ENCADRANT']);
        $encadrant->setPassword($this->passwordHasher->hashPassword($encadrant, 'encadrant'));
        $manager->persist($encadrant);

        $manager->flush();
    }
}