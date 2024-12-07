<?php

namespace App\Realm\Common;

interface RealmInterface
{
    public static function code(): string;
    public function series(): array;
    public function cards(): array;
}