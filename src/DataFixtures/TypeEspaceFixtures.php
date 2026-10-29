<?php

namespace App\DataFixtures;

use App\Factory\TypeEspaceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeEspaceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $w = json_decode(file_get_contents(__DIR__.'/data/TypeEspace.json'), true);
        foreach ($w as $i => $v) {
            TypeEspaceFactory::createOne([
                'cdTpEspace' => $i + 1,
                'tpEspLib' => $v['name'],
            ]);
        }

        $manager->flush();
    }
}
