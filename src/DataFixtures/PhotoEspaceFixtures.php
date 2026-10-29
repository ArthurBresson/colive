<?php

namespace App\DataFixtures;

use App\Factory\EspaceFactory;
use App\Factory\PhotoEspaceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PhotoEspaceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (EspaceFactory::all() as $espace) {
            PhotoEspaceFactory::createMany(rand(1, 3), ['espace' => $espace]);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EspaceFixtures::class,
        ];
    }
}
