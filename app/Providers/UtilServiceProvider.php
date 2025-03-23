<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UtilServiceProvider extends ServiceProvider
{
    public array $bindings = [
        //
    ];

    public array $singletons = [
        \Project\Shared\Utils\Response\Contracts\ResponseInterface::class => \Project\Shared\Utils\Response\Response::class,
    ];

    public function register(): void
    {

    }

    public function boot(): void
    {
        // $this->app->singleton(
        //     \Project\Shared\Utils\Response\Contracts\ResponseInterface::class,
        //     \Project\Shared\Utils\Response\Response::class
        // );

        $this->app->singleton(
            ValidatorInterface::class,
            static fn (): ValidatorInterface => Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator()
        );
    }
}
