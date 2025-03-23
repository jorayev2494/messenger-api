<?php

declare(strict_types=1);

namespace Project\Domains\Institution\Authentication\Application\Authentication\Commands\Login;

use Project\Domains\Institution\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Domains\Institution\Authentication\Domain\Account\Exceptions\AccountNotFoundDomainException;
use Project\Domains\Institution\Authentication\Domain\Account\ValueObjects\Email;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository
    ) { }

    public function __invoke(Command $command): array
    {
        $foundAccount = $this->accountRepository->findByEmail(Email::fromValue($command->email));

        $foundAccount ?? throw new AccountNotFoundDomainException();

        return [
            'uuid' => $foundAccount->getUuid()->value,
            'email' => $foundAccount->getEmail()->value,
            'created_at' => $foundAccount->getCreatedAt()->getTimestamp(),
            'updated_at' => $foundAccount->getUpdatedAt()->getTimestamp(),
        ];
    }
}