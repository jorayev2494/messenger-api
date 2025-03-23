<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Commands\Register;

use Project\Domains\Client\Authentication\Domain\Account\Account;
use Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Email;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Password;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Exceptions\EmailAlreadyExistsDomainException;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository
    ) { }

    public function __invoke(Command $command): void
    {
        $foundAccountByEmail = $this->accountRepository->findByEmail(Email::fromValue($command->email));

        if ($foundAccountByEmail !== null) {
            throw new EmailAlreadyExistsDomainException();
        }

        $account = Account::create(
            Uuid::fromValue($command->uuid),
            Email::fromValue($command->email),
            Password::fromValue($command->password)
        );

        $this->accountRepository->save($account);
    }
}