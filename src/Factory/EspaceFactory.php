<?php

namespace App\Factory;

use App\Entity\Espace;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Espace>
 */
final class EspaceFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Espace::class;
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
            'titreEsp' => self::faker()->realText(15),
            'adresseEsp' => self::faker()->streetAddress(),
            'cpEsp' => self::faker()->postcode(),
            'villeEsp' => self::faker()->city(),
            'typeEspace' => TypeEspaceFactory::random(),
            'tarif' => self::faker()->numberBetween(0, 1500),
            'datePubliEsp' => self::faker()->dateTime(),
            'commodites' => CommoditeFactory::randomRange(2, 5),
            'surface' => self::faker()->numberBetween(9, 500),
            'descEsp' => self::faker()->realText(100),
            'nbMaxColocEsp' => self::faker()->numberBetween(1, 3),
            'availableFromEsp' => self::faker()->dateTime(),
            'availableToEsp' => self::faker()->dateTime(),
            'owner' => UtilisateurFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Espace $espace): void {})
        ;
    }
}
