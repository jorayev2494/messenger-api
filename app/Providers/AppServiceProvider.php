<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Domain\Bus\Queue\QueueBusInterface;
use Project\Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use Project\Shared\Infrastructure\Bus\Messenger\MessengerEventBus;
use Project\Shared\Infrastructure\Bus\Messenger\MessengerQueryBus;
use Project\Shared\Infrastructure\Bus\Queue\QueueBus;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerBusses();
    }

    public function boot(): void
    {
        //
    }

    private function registerBusses(): void
    {
        $this->app->bind(
            EventBusInterface::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerEventBus => new MessengerEventBus($app->tagged('domain_event_subscriber'))
        );

        $this->app->bind(
            QueryBusInterface::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerQueryBus => new MessengerQueryBus($app->tagged('query_handler'))
        );

        $this->app->bind(
            CommandBusInterface::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerCommandBus => new MessengerCommandBus($app->tagged('command_handler'))
        );

        $this->app->singleton(
            QueueBusInterface::class,
            QueueBus::class
        );
    }
}
