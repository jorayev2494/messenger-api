<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Commands\RestorePassword;

use Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Password;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Uuid;
use Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\DTOs\Code\CodeAdapter;
use Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\Value;
use Project\Infrastructure\Hashers\Contracrs\PasswordHasherInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class CommandHandler
{
    public function __construct(
        private AccountRepositoryInterface $repository,
        private CodeAdapter $codeAdapter,
        private PasswordHasherInterface $passwordHasher,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $code = $this->codeAdapter->findByValue(Value::fromValue($command->code));

        if ($code === null) {
            throw new DomainException('Code is invalid');
        }

        $account = $this->repository->findByUuid(Uuid::fromValue($code->authorUuid->value));

        if ($account === null) {
            throw new DomainException('Account not found');
        }

        $account->changePassword(Password::fromValue($this->passwordHasher->hash($command->password)));
        $this->repository->save($account);
        $this->codeAdapter->delete($code->id);
        $this->eventBus->publish(...$account->pullDomainEvents());
    }
}