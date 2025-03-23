<?php

namespace App\Providers;

use App\Providers\Contracts\AppServiceProviderInterface;
use Illuminate\Support\ServiceProvider;
use Doctrine\DBAL\Types\Type;

abstract class DomainServiceProvider extends ServiceProvider implements AppServiceProviderInterface
{
    /** @var array<string, string> */
    protected const SERVICES = [
        // CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // \Project\Domains\Admin\Currency\Infrastructure\Repositories\Doctrine\Currency\Types\UuidType::class,
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
        // [
        //     'middleware' => ['api', 'auth:admin'],
        //     'prefix' => 'api/admin',
        //     'path' => __DIR__ . '/../Presentation/Http/API/REST/routes.php',
        // ],

        // [
        //     'middleware' => 'web',
        //     'prefix' => 'admin',
        //     'path' => __DIR__ . '/../Presentation/Http/Web/REST/routes.php',
        // ],
    ];

    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->registerMigrationPaths();
        $this->registerEntityPaths();
        $this->registerEntityTypes();

        $this->registerServices();
        $this->registerQueryHandlers();
        $this->registerCommandHandlers();
        $this->registerDomainEventSubscribers();
        $this->registerTranslations();
        $this->registerConfigs();
        // $this->registerNotifications();
        $this->registerRoutes();
    }

    // abstract protected function registerMigrationPaths(): void;

    // abstract protected function registerEntityPaths(): void;

    // abstract protected function registerConfigs(): void;

    // abstract protected function registerNotifications(): void;

    protected function registerMigrationPaths(): void
    {
        $this->app->addMigrationPaths(static::MIGRATION_PATHS);
    }

    protected function registerEntityPaths(): void
    {
        $this->app->addEntityPaths(static::ENTITY_PATHS);
    }

    protected function registerConfigs(): void
    {
        $this->registerConfigsByPrefix('admin');
    }

    // protected function registerNotifications(): void
    // {
    //     $this->app->addNotifications(static::NOTIFICATIONS);
    // }

    private function registerRoutes(): void
    {
        foreach (static::ROUTE_PATHS as ['middleware' => $middleware, 'prefix' => $prefix, 'path' => $path]) {
            $this->app->make('route.registrar')
                ->middleware($middleware)
                ->prefix($prefix)
                ->group($path);
        }
    }

    private function registerEntityTypes(): void
    {
        foreach (static::ENTITY_TYPES as $typeClassName) {
            Type::addType($typeClassName::NAME, $typeClassName);
        }
    }

    private function registerServices(): void
    {
        foreach (static::SERVICES as $abstractClassName => $data) {
            [$registerType, $service] = $data;
            $this->app->$registerType($abstractClassName, $service);
        }
    }

    private function registerQueryHandlers(): void
    {
        foreach (static::QUERY_HANDLERS as $className) {
            $this->app->tag($className, 'query_handler');
        }
    }

    private function registerCommandHandlers(): void
    {
        foreach (static::COMMAND_HANDLERS as $className) {
            $this->app->tag($className, 'command_handler');
        }
    }

    private function registerDomainEventSubscribers(): void
    {
        foreach (static::DOMAIN_EVENT_SUBSCRIBERS as $className) {
            $this->app->tag($className, 'domain_event_subscriber');
        }
    }

    public function registerTranslations(): void
    {
        foreach (static::TRANSLATIONS as $path => $namespace) {
            $this->loadTranslationsFrom(base_path($path), $namespace);
        }
    }

    protected function registerConfigsByPrefix(string $prefix): void
    {
        foreach (static::CONFIG_PATHS as $key => $path) {
            if (str_contains($path, '.php')) {
                $this->mergeConfigFrom($path, sprintf('%s.%s', $prefix, $key));
            } else {
                foreach (scandir($path) as $file) {
                    if (str_contains($file, '.php')) {
                        $filePath = sprintf('%s/%s', $path, $file);
                        ['filename' => $filename, 'extension' => $extension] = pathinfo($filePath);

                        $this->mergeConfigFrom($filePath, sprintf('%s.%s.%s', $prefix, $key, $filename));
                    }
                }
            }
        }
    }
}
