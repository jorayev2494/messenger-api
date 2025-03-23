<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication;

use Illuminate\Auth\AuthManager;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\Contracts\DeviceInterface;
use Project\Infrastructure\Services\Authentication\DTOs\CredentialsDTO;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

readonly class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(
        private AuthManager $authManager
    ) { }

    public function authenticate(CredentialsDTO $data, GuardType $guard, array $claims = []): string
    {
        /** @var string|boolean $token */
        if (! ($token = $this->authManager->guard($guard->value)->claims($claims)->attempt($data->toArray()))) {
            throw new BadRequestException('Invalid credentials!');
        }

        return $token;
    }

    public function authenticateByEntity(AuthenticatableInterface $authenticatable, GuardType $guard, array $claims = []): string
    {
        /** @var string $token */
        if (! ($token = $this->authManager->guard($guard->value)->claims($claims)->tokenById($authenticatable->getUuid()->value))) {
            throw new \Illuminate\Auth\AuthenticationException();
        }

        return $token;
    }

    public function invalidate(GuardType $guard): void
    {
        $this->authManager->guard($guard->value)->invalidate(true);
    }

    public function logout(GuardType $guard): void
    {
        $this->authManager->guard($guard->value)->logout();
    }

    public function authToken(string $accessToken, AuthenticatableInterface $authData, DeviceInterface $device): array
    {
        return [
            'access_token' => $accessToken,
            'token_type' => 'bearer',
            'refresh_token' => $device->getRefreshToken(),
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }
}