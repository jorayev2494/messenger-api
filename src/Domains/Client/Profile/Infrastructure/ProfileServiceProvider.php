<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Infrastructure;

use App\Providers\DomainServiceProvider;

class ProfileServiceProvider extends DomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        // CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Client\Profile\Application\Profile\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Client\Profile\Infrastructure\Profile\Repositories\Doctrine\Types\UuidType::class,
        \Project\Domains\Client\Profile\Infrastructure\Profile\Repositories\Doctrine\Types\FirstNameType::class,
        \Project\Domains\Client\Profile\Infrastructure\Profile\Repositories\Doctrine\Types\LastNameType::class,
        \Project\Domains\Client\Profile\Infrastructure\Profile\Repositories\Doctrine\Types\EmailType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Repositories\Doctrine\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        // __DIR__ . '/../Domain',
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
            'middleware' => ['api', 'auth:client'],
            'prefix' => 'api/client',
            'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        ],
    ];
}