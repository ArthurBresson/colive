<?php

namespace App\DataFixtures;

use App\Factory\CommoditeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommoditeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $w = json_decode(file_get_contents(__DIR__.'/data/Commodite.json'), true);
        foreach ($w as $i => $v) {
            CommoditeFactory::createOne([
                'id' => $i + 1,
                'nomCom' => $v['name'],
            ]);
        }

        $manager->flush();
    }
}
