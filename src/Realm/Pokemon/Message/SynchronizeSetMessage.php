<?php

namespace Tgc\Realm\Pokemon\Message;

final readonly class SynchronizeSetMessage
{
    public function __construct(
        private string $serieCode,
        private string $code,
        private string $locale,
    ) {
    }

    public function serieCode(): string
    {
        return $this->serieCode;
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