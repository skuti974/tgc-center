<?php

namespace Tgc\Realm\Pokemon\Message;

readonly class SynchronizeMessage
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