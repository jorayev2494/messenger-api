<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login;

use Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\Response\Response;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Project\Infrastructure\Services\Authentication\DTOs\CredentialsDTO;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Project\Infrastructure\Services\Authentication\Services\Contracts\DeviceServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private MemberRepositoryInterface $memberRepository,
        private AuthenticationServiceInterface $authenticationService,
        private DeviceServiceInterface $deviceService
    ) { }

    public function __invoke(Command $command): Response
    {
        $accessToken = $this->authenticationService->authenticate(
            CredentialsDTO::make($command->email, $command->password),
            GuardType::MANAGER
        );

        $account = $this->memberRepository->findByEmail(Email::fromValue($command->email));
        $device = $this->deviceService->addDeviceToAccount($account, $command->deviceId);

        $this->memberRepository->save($account);

        return Response::make(
            $this->authenticationService->authToken(
                $accessToken,
                $account,
                $device
            )
        );
    }
}