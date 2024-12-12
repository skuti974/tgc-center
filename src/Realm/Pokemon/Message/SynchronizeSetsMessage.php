<?php

namespace Tgc\Realm\Pokemon\Message;

final readonly class SynchronizeSetsMessage
{
    public function __construct(
        private string $code,
        private string $locale,
    ) {
    }

    public function code(): string
    {
        return $this->code;
    }

    public function locale(): string
    {
        return $this->locale;
    }
}