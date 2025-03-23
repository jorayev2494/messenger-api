<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Commands\Logout;

use Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Infrastructure\Services\Authentication\Auth;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Project\Infrastructure\Services\Authentication\Services\Contracts\DeviceServiceInterface;

readonly class CommandHandler
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private AuthenticationServiceInterface $authenticationService,
        private DeviceServiceInterface $deviceService
    ) { }

    public function __invoke(Command $command): void
    {
        try {
            if (($account = Auth::client()) == null) {
                return;
            }

            $this->deviceService->removeDeviceFromAccount($account, $command->deviceId);
            $this->authenticationService->invalidate(GuardType::CLIENT);

            $this->accountRepository->save($account);
        } catch (\Exception) {
            // return;
        } finally {
            $this->authenticationService->logout(GuardType::CLIENT);
        }
    }
}