<?php

declare(strict_types=1);

namespace Tgc\Realm\Pokemon;

use Tgc\Realm\Common\RealmInterface;
use Tgc\Realm\Pokemon\Controller\PokemonRealmController;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AutoconfigureTag('tgc_center.realm_tag')]
class PokemonRealm implements RealmInterface, TranslatableInterface
{
    public const REALM_CODE = 'pokemon';

    public static function code(): string
    {
        return self::REALM_CODE;
    }

    public function controllerClasses(): array
    {
        return [
            'realm' => PokemonRealmController::class,
        ];
    }

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans(self::REALM_CODE, [], 'realm');
    }

    public function series(): array
    {
    }

    public function cards(): array
    {
    }
}