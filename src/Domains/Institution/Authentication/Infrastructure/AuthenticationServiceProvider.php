<?php

declare(strict_types=1);

namespace Project\Domains\Institution\Authentication\Infrastructure;

use App\Providers\DomainServiceProvider;

class AuthenticationServiceProvider extends DomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        \Project\Domains\Institution\Authentication\Domain\Account\AccountRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Institution\Authentication\Infrastructure\Account\Repositories\Doctrine\AccountRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Institution\Authentication\Infrastructure\Account\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Institution\Authentication\Infrastructure\Account\Repositories\Doctrine\Types\EmailType::class,
        \Project\Domains\Institution\Authentication\Infrastructure\Account\Repositories\Doctrine\Types\PasswordType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Migrations' => __DIR__ . '/Repositories/Authentication/Doctrine/Migrations',
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Account'
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => 'api',
            'prefix' => 'api/institution',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}