<?php

namespace App\DataFixtures;

use App\Factory\AvisFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AvisFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        AvisFactory::createMany(20);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EspaceFixtures::class,
            UtilisateurFixtures::class,
        ];
    }
}
