<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Infrastructure;

use App\Providers\DomainServiceProvider;

class ProfileServiceProvider extends DomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Profile\Application\Profile\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Profile\Application\Profile\Commands\Update\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Profile',
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
//    protected const NOTIFICATIONS = [
//        // \Project\Domains\Admin\Notification\Infrastructure\Test\DefaultNotificationData::class,
//    ];

    /** @var array<string, string> */
    protected const ROUTE_PATHS = [
        [
            'middleware' => ['api', 'auth:manager'],
            'prefix' => 'api/admin',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}