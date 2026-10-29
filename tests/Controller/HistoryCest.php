<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Support\ControllerTester;

final class HistoryCest
{
    public function accessPage(ControllerTester $I): void
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful();
        $I->click("a[href*='/notre-histoire']");
        $I->seeInCurrentUrl('/notre-histoire');
    }

    public function correctDisplay(ControllerTester $I): void
    {
        $I->amOnPage('/notre-histoire');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Notre histoire', 'h1');
        $I->see('À propos de CoLive', '.history-eyebrow');
        $I->see('Aux origines du projet', 'h2');
        $I->see('Notre mission', 'h2');
        $I->see('Nos valeurs', 'h2');
        $I->see('Accessibilité', 'h3');
        $I->see('Confiance', 'h3');
        $I->see('Convivialité', 'h3');
        $I->see('Et demain ?', 'h2');
    }
}
