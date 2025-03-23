<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Application\Code\Commands\Create;

use Project\Domains\Client\Authentication\Domain\Account\Exceptions\AccountNotFoundDomainException;
use Project\Domains\Client\Code\Domain\Code\Code;
use Project\Domains\Client\Code\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Client\Code\Domain\Code\Enums\Type as TypeEnum;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\Type;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\AuthorUuid;
use Project\Domains\Client\Code\Infrastructure\Account\Adapter\AccountAdapter;
use Project\Domains\Client\Code\Infrastructure\Account\Adapter\DTOs\Account\VOs\Email;
use Project\Infrastructure\Generators\Contracts\CodeGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use DateTimeImmutable;

readonly class CommandHandler implements CommandHandlerInterface
{
    private const EXPIRED_AT_DATE = '+ 1 hour';

    public function __construct(
        private CodeRepositoryInterface $repository,
        private AccountAdapter $accountAdapter,
        private CodeGeneratorInterface $codeGenerator
    ) { }

    public function __invoke(Command $command): void
    {
        $account = $this->accountAdapter->findByEmail(Email::fromValue($command->email));

        $account ?? throw new AccountNotFoundDomainException();

        $foundCode = $this->repository->findByAuthorUuidAndType(
            AuthorUuid::fromValue($account->uuid->value),
            Type::fromValue($command->type)
        );

        if ($foundCode !== null) {
            $this->repository->delete($foundCode);
        }

        $code = Code::fromPrimitives(
            $this->codeGenerator->generate(),
            TypeEnum::tryFrom($command->type),
            new DateTimeImmutable(self::EXPIRED_AT_DATE),
            $account->uuid->value
        );

        $this->repository->save($code);
    }
}