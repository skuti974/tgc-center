<?php

namespace App\Realm\Common;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

readonly class RealmManager
{
    private array $realms;

    public function __construct(
        #[AutowireIterator('tgc_center.realm_tag', defaultIndexMethod: 'code')]
        iterable $realms,
    ) {
        $this->realms = $realms instanceof \Traversable ? iterator_to_array($realms) : $realms;;
    }

    public function realms(): array
    {
        return $this->realms;
    }
}