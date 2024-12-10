<?php

declare(strict_types=1);

namespace Tgc\Realm\Pokemon\Api;

use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Component\HttpFoundation\RequestStack;
use TCGdex\TCGdex;

abstract class AbstractApi
{
    private array $localizedClients = [];

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    protected function client(?string $locale = null)
    {
        if (null === $locale) {
            $locale = $this->requestStack->getCurrentRequest()->getLocale();
        }

        if (empty($this->localizedClients)) {
            TCGdex::$client = new Psr18Client();
        }

        if (!isset($this->localizedClients[$locale])) {
            $this->localizedClients[$locale] = new TCGdex($locale);
        }

        return $this->localizedClients[$locale];
    }
}