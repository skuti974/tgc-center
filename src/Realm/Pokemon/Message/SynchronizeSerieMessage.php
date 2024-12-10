<?php

namespace Tgc\Realm\Pokemon\Message;

final readonly class SynchronizeSerieMessage
{
    public function __construct(
        private string $code,
        private string $name,
        private string $locale,
    ) {
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function locale(): string
    {
        return $this->locale;
    }
}