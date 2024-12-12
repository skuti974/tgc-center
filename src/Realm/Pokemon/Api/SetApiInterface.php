<?php

namespace Tgc\Realm\Pokemon\Api;

use TCGdex\Model\Set;

interface SetApiInterface
{
    public function findByCode(string $setCode, ?string $locale = null): ?Set;
}