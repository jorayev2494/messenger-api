<?php

declare(strict_types=1);

namespace Project\Shared\Utils;

use Illuminate\Support\ServiceProvider;

class SharedUtilsServiceProvider extends ServiceProvider
{
    public array $singletons = [
        \Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface::class => \Project\Infrastructure\Generators\UuidGenerator::class,
    ];
}