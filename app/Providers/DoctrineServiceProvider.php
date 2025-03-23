<?php

declare(strict_types=1);

namespace App\Providers;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;
use Project\Shared\Infrastructure\Repository\EntityManager;
use Doctrine\ORM\ORMSetup;
use Illuminate\Support\ServiceProvider;
use JetBrains\PhpStorm\NoReturn;
use Project\Shared\Infrastructure\Repository\Contracts\EntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\EventSubscribers\MigrationEventSubscriber;

class DoctrineServiceProvider extends ServiceProvider
{
    private EventManager $eventManager;

    private array $connection = [];

    #[NoReturn]
    public function register(): void
    {
        $this->connection = [
            'dbname' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'driver' => 'pdo_mysql',
        ];

        $this->connectEntityManager();
    }

    public function boot(): void
    {
        //
    }

    #[NoReturn]
    private function connectEntityManager(): void
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $this->app->make('doctrine_entity_paths')->toArray(),
            isDevMode: !$this->app->environment('production'),
        );

        $connection = DriverManager::getConnection($this->connection, $config); // , $this->getEventManager()
        $entityManager = new EntityManager($connection, $config);

        // dd(EntityManagerInterface::class, $entityManager);
        $this->app->singleton(EntityManagerInterface::class, static fn () => $entityManager);
        // $this->app->singleton(\Project\Shared\Infrastructure\Repository\Contracts\EntityManagerInterface::class, $entityManager);
        $this->app->instance('dbal_connection', $connection);
    }

    private function getEventManager(): EventManager
    {
        $eventManager = new EventManager();

        // TranslatableListener
        // $cache = new ArrayAdapter();
        // $translatableListener = new TranslatableListener();
        // $translatableListener->setTranslatableLocale('en'); // en_us
        // $translatableListener->setDefaultLocale('en');  // en_us
        // $translatableListener->setAnnotationReader(new AttributeReader());
        // $translatableListener->setCacheItemPool($cache);
        // $eventManager->addEventSubscriber($translatableListener);

        //
        $migrationEventSubscriber = new MigrationEventSubscriber();
        $eventManager->addEventSubscriber($migrationEventSubscriber);

        return $eventManager;
    }
}
