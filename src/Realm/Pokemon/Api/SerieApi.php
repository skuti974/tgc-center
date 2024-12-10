<?php

declare(strict_types=1);

namespace Tgc\Realm\Pokemon\Api;

class SerieApi extends AbstractApi implements SerieApiInterface
{
    public function all(?string $locale = null): array
    {
        return $this->client($locale)->fetchSeries();
    }
}