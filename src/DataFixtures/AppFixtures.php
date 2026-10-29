<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $u = new Utilisateur();
        $u->setEmail('test@colive.fr');
        $u->setNomUtil('Test');
        $u->setPrenomUtil('User');
        $u->setCpUtil('51100');
        $u->setAdresseUtil('1 rue de test');
        $u->setVilleUtil('Reims');
        $u->setRoles(['ROLE_USER']);
        $u->setPassword($this->hasher->hashPassword($u, 'test1234'));

        $manager->persist($u);
        $manager->flush();
    }
}
