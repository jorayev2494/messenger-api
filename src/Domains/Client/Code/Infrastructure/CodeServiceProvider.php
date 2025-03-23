<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Infrastructure;

use App\Providers\DomainServiceProvider;

class CodeServiceProvider extends DomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        \Project\Domains\Client\Code\Domain\Code\CodeRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine\CodeRepository::class],
        \Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\Contracts\CodeApiInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Client\Code\Infrastructure\Code\Api\Authentication\CodeApi::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Client\Code\Application\Code\Commands\Create\CommandHandler::class,
        \Project\Domains\Client\Code\Application\Code\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // \Project\Domains\Client\Code\Application\Code\Subscribers\Authentication\AccountPasswordWasChangedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine\Types\AuthorUuidType::class,
        \Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine\Types\ValueType::class,
        \Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine\Types\TypeType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Migrations' => __DIR__ . '/Repositories/Authentication/Doctrine/Migrations',
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Code',
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