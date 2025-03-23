<?php

namespace Project\Domains\Admin\Manager\Infrastructure;

use App\Providers\DomainServiceProvider;

class ManagerServiceProvider extends DomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        \Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\ManagerRepository::class],

        // ACL
        \Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\Contracts\ManagerApiInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Manager\Infrastructure\APIs\Profile\ManagerApi::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Manager\Application\Manager\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Manager\Application\Manager\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Manager\Commands\Delete\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [

    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\EmailType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\FirstNameType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\LastNameType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Migrations' => __DIR__ . '/Repositories/Authentication/Doctrine/Migrations',
        // 'Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Manager',
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