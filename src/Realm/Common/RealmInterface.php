<?php

declare(strict_types=1);

namespace Tgc\Realm\Common;

interface RealmInterface
{
    public static function code(): string;

    public function controllerClasses(): array;

    public function series(): array;

    public function cards(): array;
}