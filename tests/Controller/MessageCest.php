<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Support\ControllerTester;

final class MessageCest
{
    // On définit l'email root ici
    private string $emailRoot = 'root@example.com';

    /**
     * Vérifie que root peut accéder à la liste des utilisateurs.
     */
    public function showUserList(ControllerTester $I): void
    {
        $I->login($this->emailRoot);
        $I->amOnPage('/utilisateurs');

        $I->seeResponseCodeIsSuccessful();
        $I->see('Membres', 'h2');
        // Vérifie qu'il y a au moins un bouton de message (le lien vers app_message_start)
        $I->seeElement('a[href*="/messages/start/"]');
    }

    /**
     * Vérifie l'ouverture d'une conversation.
     */
    public function checkConversationDisplay(ControllerTester $I): void
    {
        $I->login($this->emailRoot);
        $I->amOnPage('/utilisateurs');

        // Clique sur le premier bouton de message trouvé
        $I->click('a[href*="/messages/start/"]');

        $I->seeResponseCodeIsSuccessful();
        // Vérifie que le formulaire de message est présent
        $I->seeElement('textarea');
        $I->see('Envoyer', 'button');
    }

    /**
     * Simule l'envoi d'un message par root.
     */
    public function sendMessage(ControllerTester $I): void
    {
        $I->login($this->emailRoot);
        $I->amOnPage('/utilisateurs');

        // On engage la conversation avec le premier utilisateur de la liste
        $I->click('a[href*="/messages/start/"]');

        $payload = 'Ceci est un message de test généré par le compte Root '.uniqid();

        // On remplit le champ message. 'textarea' cible la balise HTML.
        $I->fillField('textarea', $payload);

        // On clique sur le bouton de soumission
        $I->click('Envoyer');

        $I->seeResponseCodeIsSuccessful();
        // On vérifie que le message s'affiche bien dans le fil de discussion
        $I->see($payload);
    }
}
