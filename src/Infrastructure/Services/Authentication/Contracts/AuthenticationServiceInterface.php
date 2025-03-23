<?php

namespace Project\Infrastructure\Services\Authentication\Contracts;

use Project\Infrastructure\Services\Authentication\DTOs\CredentialsDTO;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;

interface AuthenticationServiceInterface
{
    public function authenticate(CredentialsDTO $data, GuardType $guard, array $claims = []): string;

    public function authenticateByEntity(AuthenticatableInterface $authenticatable, GuardType $guard, array $claims = []): string;

    public function invalidate(GuardType $guard): void;

    public function logout(GuardType $guard): void;

    public function authToken(string $accessToken, AuthenticatableInterface $authData, DeviceInterface $device): array;
}