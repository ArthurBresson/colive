<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Factory\EspaceFactory;
use App\Tests\Support\ControllerTester;

final class EspaceCest
{
    public function ListeDesLogements(ControllerTester $I): void
    {
        $factory = EspaceFactory::createMany(5);
        $I->amOnPage('/espace');
        $I->seeResponseCodeIsSuccessful();

        $I->assertSelectorTextContains('h3', 'Liste des logements');
        $I->seeNumberOfElements('.col-lg-4', 55);
        $I->assertSelectorExists('form[role="search"]');
        $I->assertSelectorExists('input[name="search"]');
    }

    public function searchFormCanBeFilledAndSent(ControllerTester $I): void
    {
        $I->amOnPage('/espace');
        $I->seeResponseCodeIsSuccessful();
        $I->fillField('search', 'foo');
        $I->click('Rechercher');
        $I->seeCurrentRouteIs('app_espace');
        $I->seeInCurrentUrl('search=foo');
    }

    public function goodDirection(ControllerTester $I): void
    {
        $espace = EspaceFactory::createOne(['titreEsp' => 'Logement Test']);
        $id = $espace->getId();

        $I->amOnPage('/espace');
        $I->seeResponseCodeIsSuccessful();
        $I->click("a[href*='espace/$id']");
        $I->seeInCurrentUrl("/espace/$id");
    }
}
