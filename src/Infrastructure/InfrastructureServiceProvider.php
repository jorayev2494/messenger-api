<?php

declare(strict_types=1);

namespace Project\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Infrastructure\Generators\CodeGenerator;
use Project\Infrastructure\Generators\Contracts\CodeGeneratorInterface;
use Project\Infrastructure\Generators\Contracts\PasswordGenerateInterface;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Infrastructure\Generators\PasswordGenerate;
use Project\Infrastructure\Generators\TokenGenerator;
use Project\Infrastructure\Generators\UuidGenerator;
use Project\Infrastructure\Hashers\Contracrs\PasswordHasherInterface;
use Project\Infrastructure\Hashers\PasswordHasher;
use Project\Infrastructure\Services\Authentication\AuthenticationService;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\Services\Contracts\DeviceServiceInterface;
use Project\Infrastructure\Services\Authentication\Services\DeviceService;
use Project\Infrastructure\Services\WS\Contracts\WSServiceInterface;
use Project\Infrastructure\Services\WS\WSService;

class InfrastructureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // $this->app->singleton(AuthManagerInterface::class, AuthManager::class);
        $this->app->singleton(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->singleton(DeviceServiceInterface::class, DeviceService::class);
        $this->app->singleton(
            WSServiceInterface::class,
            static fn (): WSServiceInterface => new WSService(
                new \phpcent\Client(
                    config('ws.centrifuge.url'),
                    config('ws.centrifuge.api_key'),
                    config('ws.centrifuge.secret_key')
                )
            )
        );

        $this->app->singleton(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->singleton(TokenGeneratorInterface::class, TokenGenerator::class);
        $this->app->singleton(CodeGeneratorInterface::class, CodeGenerator::class);
        $this->app->singleton(PasswordGenerateInterface::class, PasswordGenerate::class);

        $this->app->singleton(PasswordHasherInterface::class, PasswordHasher::class);
    }
}