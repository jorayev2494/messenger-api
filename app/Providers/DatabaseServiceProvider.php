<?php

namespace App\Providers;

use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        #region Entities
        $this->app->singleton('doctrine_entity_paths', static fn (): ArrayCollection => new ArrayCollection());

        \Illuminate\Foundation\Application::macro('addEntityPaths', function (array $entityPaths): void {
            $entityPathCollect = $this->make('doctrine_entity_paths');

            foreach ($entityPaths as $entityPath) {
                $entityPathCollect->add($entityPath);
            }
        });

//        // Admin
//        $this->app->singleton('admin_doctrine_entity_paths', static fn (): ArrayCollection => new ArrayCollection());
//
//        \Illuminate\Foundation\Application::macro('addAdminEntityPaths', function (array $entityPaths): void {
//            $entityPathCollect = $this->make('admin_doctrine_entity_paths');
//
//            foreach ($entityPaths as $entityPath) {
//                $entityPathCollect->add($entityPath);
//            }
//        });

//        // Company
//        $this->app->singleton('company_doctrine_entity_paths', static fn (): ArrayCollection => new ArrayCollection());
//
//        \Illuminate\Foundation\Application::macro('addCompanyEntityPaths', function (array $entityPaths): void {
//            $entityPathCollect = $this->make('company_doctrine_entity_paths');
//
//            foreach ($entityPaths as $entityPath) {
//                $entityPathCollect->add($entityPath);
//            }
//        });

//        // Client
//        $this->app->singleton('client_doctrine_entity_paths', static fn (): ArrayCollection => new ArrayCollection());
//
//        \Illuminate\Foundation\Application::macro('addClientEntityPaths', function (array $entityPaths): void {
//            $entityPathCollect = $this->make('client_doctrine_entity_paths');
//
//            foreach ($entityPaths as $entityPath) {
//                $entityPathCollect->add($entityPath);
//            }
//        });
        #endregion

        #region Migrations
//        $this->app->singleton('doctrine_migration_paths', static fn (): array => []);
//
//        \Illuminate\Foundation\Application::macro('addMigrationPaths', function (array $migrationsPaths): void {
//            $migrationPathCollection = $this->make('doctrine_migration_paths');
//            $this->singleton('doctrine_migration_paths', static fn (): array => array_merge($migrationPathCollection, $migrationsPaths));
//        });
//
        $this->app->singleton('doctrine_migration_paths', static fn (): array => []);

        \Illuminate\Foundation\Application::macro('addMigrationPaths', function (array $migrationsPaths): void {
            $migrationPathCollection = $this->make('doctrine_migration_paths');
            $this->singleton('doctrine_migration_paths', static fn (): array => array_merge($migrationPathCollection, $migrationsPaths));
        });
//
//        $this->app->singleton('doctrine_migration_paths', static fn (): array => []);
//
//        \Illuminate\Foundation\Application::macro('addMigrationPaths', function (array $migrationsPaths): void {
//            $migrationPathCollection = $this->make('doctrine_migration_paths');
//            $this->singleton('doctrine_migration_paths', static fn (): array => array_merge($migrationPathCollection, $migrationsPaths));
//        });
        #endregion
    }

    public function boot(): void
    {
        //
    }
}
