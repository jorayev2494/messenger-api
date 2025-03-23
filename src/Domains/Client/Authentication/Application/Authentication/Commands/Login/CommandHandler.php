<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Commands\Login;

use Project\Domains\Client\Authentication\Application\Authentication\Commands\Login\Response\Response;
use Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Email;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\DTOs\CredentialsDTO;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Project\Infrastructure\Services\Authentication\Services\Contracts\DeviceServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private AuthenticationServiceInterface $authenticationService,
        private DeviceServiceInterface $deviceService
    ) { }

    public function __invoke(Command $command): Response
    {
        $accessToken = $this->authenticationService->authenticate(
            CredentialsDTO::make($command->email, $command->password),
            GuardType::CLIENT
        );

        $account = $this->accountRepository->findByEmail(Email::fromValue($command->email));
        $device = $this->deviceService->addDeviceToAccount($account, $command->deviceId);

        $this->accountRepository->save($account);

        return Response::make(
            $this->authenticationService->authToken(
                $accessToken,
                $account,
                $device
            )
        );
    }
}