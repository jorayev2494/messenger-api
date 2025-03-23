<?php

namespace Project\Domains\Admin\Role\Infrastructure;

use App\Providers\DomainServiceProvider;

class RoleServiceProvider extends DomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        \Project\Domains\Admin\Role\Domain\Role\RoleRepositoryInterface::class => [self::SERVICE_BIND, \Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\RoleRepository::class],
        \Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\PermissionRepository::class],
        \Project\Domains\Admin\Role\Domain\Member\MemberRepositoryInterface::class => [self::SERVICE_SINGLETON, \Project\Domains\Admin\Role\Infrastructure\Member\Repositories\Doctrine\MemberRepository::class]
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Role\Application\Role\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Role\Application\Role\Queries\Show\QueryHandler::class,

        \Project\Domains\Admin\Role\Application\Member\Queries\GetRole\QueryHandler::class,

        // Permission
        \Project\Domains\Admin\Role\Application\Permission\Queries\List\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Role\Application\Role\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Role\Application\Role\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Role\Application\Role\Commands\Delete\CommandHandler::class,
        \Project\Domains\Admin\Role\Application\Role\Commands\ChangePermissions\CommandHandler::class,

        // Permission
        \Project\Domains\Admin\Role\Application\Permission\Commands\Create\CommandHandler::class,

        // Member
        \Project\Domains\Admin\Role\Application\Member\Commands\SetRole\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // Member
        \Project\Domains\Admin\Role\Application\Member\Subscribers\Manager\ManagerWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Admin\Role\Application\Member\Subscribers\Manager\ManagerWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Role
        \Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\Types\ValueType::class,
        \Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\Types\DescriptionType::class,
        \Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\Types\IsSuperAdminType::class,

        // Permission
        \Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types\IdType::class,
        \Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types\LabelType::class,
        \Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types\ActionType::class,
        \Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types\ResourceType::class,

        // Member
        \Project\Domains\Admin\Role\Infrastructure\Member\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Admin\Role\Infrastructure\Member\Repositories\Doctrine\Types\RoleUuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Role',
        __DIR__ . '/../Domain/Permission',
        __DIR__ . '/../Domain/Member',
    ];

    /** @var array<array-key, string> */
    protected const TRANSLATIONS = [
        // 'src/Domains/Admin/Student/Infrastructure/Student/Translations' => 'project.domains.admin.student.infrastructure.student.translations',
    ];

    /** @var array<string, string> */
    protected const CONFIG_PATHS = [
        // 'key' => 'path',
    ];

    //    /** @var array<array-key, NotificationData> */
    protected const NOTIFICATIONS = [
        // \Project\Domains\Admin\Notification\Infrastructure\Test\DefaultNotificationData::class,
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