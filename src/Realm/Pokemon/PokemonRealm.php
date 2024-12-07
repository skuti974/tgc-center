<?php

namespace App\Realm\Pokemon;

use App\Realm\Common\RealmInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('tgc_center.realm_tag')]
class PokemonRealm implements RealmInterface
{
    public const REALM_CODE = 'pokemon';

    public static function code(): string
    {
        return self::REALM_CODE;
    }

    public function series(): array
    {
    }

    public function cards(): array
    {
    }
}