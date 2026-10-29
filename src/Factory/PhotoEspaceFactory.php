<?php

namespace App\Factory;

use App\Entity\PhotoEspace;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<PhotoEspace>
 */
final class PhotoEspaceFactory extends PersistentProxyObjectFactory
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
        return PhotoEspace::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        $path = __DIR__.'/../../assets/images/espace_default_images';
        $files = glob($path.'/*.{jpg,jpeg,png}', GLOB_BRACE);
        $image = file_get_contents($files[array_rand($files)]);

        return [
            'nom' => 'a',
            'img' => $image,
            'imgType' => 'image/jpeg',
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(PhotoEspace $photoEspace): void {})
        ;
    }
}
