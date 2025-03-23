<?php

namespace Project\Domains\Admin\Client\Infrastructure;

use App\Providers\DomainServiceProvider;

class ClientServiceProvider extends DomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        \Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\ClientRepository::class],

        // ACL
        // \Project\Domains\Admin\Profile\Infrastructure\Adapters\Client\Contracts\ClientApiInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Client\Infrastructure\APIs\Profile\ClientApi::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Client\Application\Client\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Client\Application\Client\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Client\Application\Client\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Client\Application\Client\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Client\Application\Client\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [

    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types\EmailType::class,
        \Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types\FirstNameType::class,
        \Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types\LastNameType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Migrations' => __DIR__ . '/Repositories/Authentication/Doctrine/Migrations',
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Client',
    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:manager'],
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}