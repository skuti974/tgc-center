<?php

declare(strict_types=1);

namespace Tgc\Realm\Pokemon\Api;

use TCGdex\Model\Serie;

class SerieApi extends AbstractApi implements SerieApiInterface
{
    public function all(?string $locale = null): ?array
    {
        return $this->client($locale)->fetchSeries();
    }

    public function findByCode(string $serieCode, ?string $locale = null): ?Serie
    {
        return $this->client($locale)->fetchSerie($serieCode);
    }
}