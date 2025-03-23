<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\Logout;

use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Infrastructure\Services\Authentication\Auth;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Project\Infrastructure\Services\Authentication\Services\Contracts\DeviceServiceInterface;

readonly class CommandHandler
{
    public function __construct(
        private MemberRepositoryInterface $memberRepository,
        private AuthenticationServiceInterface $authenticationService,
        private DeviceServiceInterface $deviceService
    ) { }

    public function __invoke(Command $command): void
    {
        try {
            if (($account = Auth::manager()) === null) {
                return;
            }

            $this->deviceService->removeDeviceFromAccount($account, $command->deviceId);
            $this->authenticationService->invalidate(GuardType::MANAGER);

            $this->memberRepository->save($account);
        } catch (\Exception) {
            // return;
        } finally {
            $this->authenticationService->logout(GuardType::MANAGER);
        }
    }
}