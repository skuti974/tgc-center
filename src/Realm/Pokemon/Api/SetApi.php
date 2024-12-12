<?php

namespace Tgc\Realm\Pokemon\Api;

use TCGdex\Model\Set;

class SetApi extends AbstractApi implements SetApiInterface
{
    public function findByCode(string $setCode, ?string $locale = null): ?Set
    {
        return $this->client($locale)->fetchSet($setCode);
    }
}