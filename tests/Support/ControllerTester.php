<?php

declare(strict_types=1);

namespace App\Tests\Support;

use App\Entity\Utilisateur;

/**
 * Inherited Methods.
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
 */
class ControllerTester extends \Codeception\Actor
{
    use _generated\ControllerTesterActions;

    public function login(string $email): void
    {
        $em = $this->grabService('doctrine.orm.entity_manager');
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

        if (!$user) {
            throw new \Exception("L'utilisateur de test avec l'email $email n'existe pas en base. Pensez à le créer ou à charger les fixtures.");
        }

        $this->amLoggedInAs($user);
    }

    /*
     * Define custom actions here
     */
}
