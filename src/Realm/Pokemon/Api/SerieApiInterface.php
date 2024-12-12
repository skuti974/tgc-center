<?php

namespace Tgc\Realm\Pokemon\Api;

use TCGdex\Model\Serie;

interface SerieApiInterface
{
    public function all(?string $locale = null): ?array;

    public function findByCode(string $serieCode, ?string $locale = null): ?Serie;
}