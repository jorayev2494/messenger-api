<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\RefreshToken;

use Project\Domains\Admin\Authentication\Application\Authentication\Commands\RefreshToken\Response\Response;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class CommandHandler
{
    public function __construct(
        private DeviceRepositoryInterface $deviceRepository,
        private AuthenticationServiceInterface $authenticationService,
        private TokenGeneratorInterface $tokenGenerator
    ) { }

    public function __invoke(Command $command): Response
    {
        $foundDevice = $this->deviceRepository->findByDeviceIdAndRefreshToken($command->deviceId, $command->refreshToken);

        $foundDevice ?? throw new DomainException('Refresh token is invalid');

        $accessToken = $this->authenticationService->authenticateByEntity(
            $foundDevice->getAuthor(),
            GuardType::MANAGER
        );
        $foundDevice->setRefreshToken($this->tokenGenerator->generate());

        $this->deviceRepository->save($foundDevice);

        return Response::make(
            $this->authenticationService->authToken(
                $accessToken,
                $foundDevice->getAuthor(),
                $foundDevice
            )
        );
    }
}