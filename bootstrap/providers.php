<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\DatabaseServiceProvider::class,
    App\Providers\DoctrineServiceProvider::class,
    // App\Providers\DomainServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\UtilServiceProvider::class,

    // Shared
    \Project\Shared\Utils\SharedUtilsServiceProvider::class,

    // Infrastructure
    \Project\Infrastructure\InfrastructureServiceProvider::class,

    // Admin
    \Project\Domains\Admin\Authentication\Infrastructure\AuthenticationServiceProvider::class,
    \Project\Domains\Admin\Code\Infrastructure\CodeServiceProvider::class,
    \Project\Domains\Admin\Profile\Infrastructure\ProfileServiceProvider::class,
    \Project\Domains\Admin\Manager\Infrastructure\ManagerServiceProvider::class,
    \Project\Domains\Admin\Client\Infrastructure\ClientServiceProvider::class,
    \Project\Domains\Admin\Role\Infrastructure\RoleServiceProvider::class,

    // Institution
    // \Project\Domains\Institution\Authentication\Infrastructure\AuthenticationServiceProvider::class,

    // Client
    \Project\Domains\Client\Authentication\Infrastructure\AuthenticationServiceProvider::class,
    \Project\Domains\Client\Code\Infrastructure\CodeServiceProvider::class,
    \Project\Domains\Client\Profile\Infrastructure\ProfileServiceProvider::class,

    // Public
    // \Project\Domains\Public\Test\Infrastructure\TestServiceProvider::class,
];
