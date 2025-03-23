<?php

require_once __DIR__ . '/public/index.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\ORMSetup;
use Project\Shared\Infrastructure\Repository\Contracts\EntityManagerInterface;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use Illuminate\Foundation\Application;

$dbalKey = null;
$migrationsPaths = [];

$entity = getenv('ENTITY');

if (in_array($entity, ['admin', 'company', 'client'])) {

    //    if ($entity === 'client')
    //    {
    //        /** @var EntityManagerInterface $entityManager */
    //        $entityManager = $app->make(ClientEntityManagerInterface::class);
    //        $migrationsPaths = $app->make('client_doctrine_migration_paths');
    //        $entityManager->getConfiguration()
    //            ->setMetadataDriverImpl(
    //                new AttributeDriver($app->make('client_doctrine_entity_paths')->toArray())
    //            );
    //
    //        $dbalKey = 'client_dbal_connection';
    //    }
    //    else if ($entity === 'company')
    //    {
    //        /** @var EntityManagerInterface $entityManager */
    //        $entityManager = $app->make(CompanyEntityManagerInterface::class);
    //        $migrationsPaths = $app->make('company_doctrine_migration_paths');
    //        $entityManager->getConfiguration()
    //            ->setMetadataDriverImpl(
    //                new AttributeDriver($app->make('company_doctrine_entity_paths')->toArray())
    //            );
    //
    //        $dbalKey = 'company_dbal_connection';
    //    }
    //    else
    //    if ($entity === 'admin')
    //    {
    //        /** @var EntityManagerInterface $entityManager */
    //        $entityManager = $app->make(AdminEntityManagerInterface::class);
    //        $migrationsPaths = $app->make('admin_doctrine_migration_paths');
    //        $entityManager->getConfiguration()
    //            ->setMetadataDriverImpl(
    //                new AttributeDriver($app->make('admin_doctrine_entity_paths')->toArray())
    //            );
    //
    //        $dbalKey = 'admin_dbal_connection';
    //    }

    function connectEntityManager(Application $app): void
    {
        $connection = [
            'dbname' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'driver' => 'pdo_mysql',
        ];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $app->make('doctrine_entity_paths')->toArray(),
            isDevMode: !$app->environment('production'),
        );

        $connection = DriverManager::getConnection($connection, $config); // , $this->getEventManager()
        $entityManager = new EntityManager($connection, $config);

        $app->singleton(\Project\Shared\Infrastructure\Repository\Contracts\EntityManagerInterface::class, static fn () => $entityManager);
        $app->instance('dbal_connection', $connection);
    }

    connectEntityManager($app);

    /** @var EntityManagerInterface $entityManager */
    $entityManager = $app->make(\Project\Shared\Infrastructure\Repository\Contracts\EntityManagerInterface::class);
    $migrationsPaths = $app->make('doctrine_migration_paths');
    // dd($migrationsPaths);
    $entityManager->getConfiguration()
        ->setMetadataDriverImpl(
            new AttributeDriver($app->make('doctrine_entity_paths')->toArray())
        );

    $dbalKey = 'dbal_connection';

    $conf = [
        'table_storage' => [
            'table_name' => 'doctrine_migration_versions',
            'version_column_name' => 'version',
            'version_column_length' => 191,
            'executed_at_column_name' => 'executed_at',
            'execution_time_column_name' => 'execution_time',
        ],

        // 'migrations_paths' => [
        //     // 'Project\Domains\Admin\Country\Infrastructure\Doctrine\Migrations' => '/var/project/src/Domains/Admin/Country/Infrastructure/Doctrine/Migrations',
        // ],

        'migrations_paths' => [...$migrationsPaths],

        'all_or_nothing' => true,
        'transactional' => true,
        'check_database_platform' => true,
        'organize_migrations' => 'none',
        'connection' => null,
        'em' => null,
    ];

    $config = new ConfigurationArray($conf);

    /** @var \Doctrine\DBAL\Connection $dbalConnection */
    $dbalConnection = $app->make($dbalKey);

    $di = DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));

    // $di->setService(\Doctrine\Migrations\Version\Comparator::class, new \Project\Shared\Infrastructure\Repository\Doctrine\ProjectVersionComparator());

    return $di;
}
