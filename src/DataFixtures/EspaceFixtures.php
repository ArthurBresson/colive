<?php

namespace App\DataFixtures;

use App\Factory\EspaceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EspaceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        EspaceFactory::createMany(50);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TypeEspaceFixtures::class,
        ];
    }
}
