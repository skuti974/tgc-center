<?php

namespace Tgc\Realm\Pokemon\Message;

readonly class SynchronizeSeriesMessage
{
    public function __construct(
        private string $locale,
    ) {
    }

    public function locale(): string
    {
        return $this->locale;
    }
}