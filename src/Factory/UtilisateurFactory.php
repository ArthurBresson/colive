<?php

namespace App\Factory;

use App\Entity\Utilisateur;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Utilisateur>
 */
final class UtilisateurFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private ?UserPasswordHasherInterface $passwordHasher = null,
    ) {
        parent::__construct();
    }

    #[\Override]
    public static function class(): string
    {
        return Utilisateur::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'adresseUtil' => self::faker()->streetAddress(),
            'cpUtil' => self::faker()->postcode(),
            'email' => strtolower(self::faker()->userName().'@'.self::faker()->domainName()),
            'nomUtil' => self::faker()->unique()->name(),
            'prenomUtil' => self::faker()->unique()->lastName(),
            'villeUtil' => self::faker()->city(),
            'password' => 'test',
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (Utilisateur $user) {
                if (null !== $this->passwordHasher) {
                    $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
                }
            })
        ;
    }
}
