<?php

namespace Tgc\Realm\Pokemon\Api;

interface SerieApiInterface
{
    public function all(?string $locale = null): array;
}