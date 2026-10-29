<?php

namespace App\DataFixtures;

use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        UtilisateurFactory::createOne([
            'prenomUtil' => 'Tony',
            'nomUtil' => 'Stark',
            'email' => 'root@example.com',
            'roles' => ['ROLE_ADMIN'],
        ]);

        UtilisateurFactory::createOne([
            'prenomUtil' => 'Peter',
            'nomUtil' => 'Parker',
            'email' => 'user@example.com',
            'roles' => ['ROLE_USER'],
        ]);

        UtilisateurFactory::createMany(10);

        $manager->flush();
    }
}
