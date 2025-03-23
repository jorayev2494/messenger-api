<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure;

use App\Providers\DomainServiceProvider;

class AuthenticationServiceProvider extends DomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        \Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Authentication\Infrastructure\Member\Repositories\Doctrine\MemberRepository::class],
        \Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Authentication\Infrastructure\Device\Repositories\Doctrine\DeviceRepository::class],

        // Adapters
        \Project\Domains\Admin\Code\Infrastructure\Account\Adapter\Contracts\MemberApiInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Authentication\Infrastructure\Member\Api\Code\MemberApi::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Authentication\Commands\Logout\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Authentication\Commands\RefreshToken\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Authentication\Commands\RestorePassword\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Authentication\Application\Authentication\Subscribers\Manager\ManagerWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Admin\Authentication\Application\Authentication\Subscribers\Manager\ManagerEmailWasChangedDomainEventSubscriber::class,
        \Project\Domains\Admin\Authentication\Application\Authentication\Subscribers\Manager\ManagerWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Types\EmailType::class,
        \Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Types\PasswordType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Migrations' => __DIR__ . '/Repositories/Authentication/Doctrine/Migrations',
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Member',
        __DIR__ . '/../Domain/Device',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => 'api',
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}