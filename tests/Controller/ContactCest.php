<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Support\ControllerTester;

final class ContactCest
{
    public function accessPage(ControllerTester $I): void
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful();
        $I->click("a[href*='/contact']");
        $I->seeInCurrentUrl('/contact');
    }

    public function correctDisplay(ControllerTester $I): void
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Contact', 'h1');
        $I->seeElement('form');
        $I->see('Nom', 'label');
        $I->seeElement('input', ['id' => 'contact_name', 'placeholder' => 'Votre nom']);
        $I->see('Email', 'label');
        $I->seeElement('input', ['id' => 'contact_email', 'placeholder' => 'vous@example.com']);
        $I->see('Sujet', 'label');
        $I->seeElement('input', ['id' => 'contact_subject', 'placeholder' => 'Sujet de votre message']);
        $I->see('Message', 'label');
        $I->seeElement('textarea', ['id' => 'contact_message', 'placeholder' => 'Expliquez-nous votre demande']);
        $I->see('Envoyer le message', 'button');
        $I->seeElement('.btn-send');
    }
}
