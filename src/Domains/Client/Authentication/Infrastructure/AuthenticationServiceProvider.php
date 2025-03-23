<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure;

use App\Providers\DomainServiceProvider;

class AuthenticationServiceProvider extends DomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        \Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Client\Authentication\Infrastructure\Account\Repositories\Doctrine\AccountRepository::class],
        \Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Client\Authentication\Infrastructure\Device\Repositories\Doctrine\DeviceRepository::class],

        // Adapters
        \Project\Domains\Client\Code\Infrastructure\Account\Adapter\Contracts\AccountApiInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Client\Authentication\Infrastructure\Account\Api\Code\AccountApi::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Client\Authentication\Application\Authentication\Commands\Login\CommandHandler::class,
        \Project\Domains\Client\Authentication\Application\Authentication\Commands\Register\CommandHandler::class,
        \Project\Domains\Client\Authentication\Application\Authentication\Commands\RefreshToken\CommandHandler::class,
        \Project\Domains\Client\Authentication\Application\Authentication\Commands\Logout\CommandHandler::class,
        \Project\Domains\Client\Authentication\Application\Authentication\Commands\RestorePassword\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Client\Authentication\Application\Authentication\Subscribers\Client\ClientWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Authentication\Application\Authentication\Subscribers\Client\ClientEmailWasChangedDomainEventSubscriber::class,
        \Project\Domains\Client\Authentication\Application\Authentication\Subscribers\Client\ClientWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Client\Authentication\Infrastructure\Account\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Client\Authentication\Infrastructure\Account\Repositories\Doctrine\Types\EmailType::class,
        \Project\Domains\Client\Authentication\Infrastructure\Account\Repositories\Doctrine\Types\PasswordType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Migrations' => __DIR__ . '/Repositories/Authentication/Doctrine/Migrations',
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Account',
        __DIR__ . '/../Domain/Device',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => 'api',
            'prefix' => 'api/client',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}