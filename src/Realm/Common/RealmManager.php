<?php

declare(strict_types=1);

namespace Tgc\Realm\Common;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\OptionsResolver\OptionsResolver;

readonly class RealmManager
{
    private array $realms;

    public function __construct(
        #[AutowireIterator('tgc_center.realm_tag', defaultIndexMethod: 'code')]
        iterable $realms,
    ) {
        $this->realms = $realms instanceof \Traversable ? iterator_to_array($realms) : $realms;
        $this->validate();
    }

    /**
     * @return array<string, RealmInterface>
     */
    public function realms(): array
    {
        return $this->realms;
    }

    private function validate(): void
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired([
            'realm',
        ]);

        foreach ($this->realms() as $realm) {
            $resolver->resolve($realm->controllerClasses());
        }
    }
}