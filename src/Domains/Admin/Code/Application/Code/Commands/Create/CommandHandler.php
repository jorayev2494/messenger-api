<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Application\Code\Commands\Create;

use Project\Domains\Admin\Code\Domain\Code\Queues\SendEmailQueue;
use Project\Domains\Client\Authentication\Domain\Account\Exceptions\AccountNotFoundDomainException;
use Project\Domains\Admin\Code\Domain\Code\Code;
use Project\Domains\Admin\Code\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Admin\Code\Domain\Code\Enums\Type as TypeEnum;
use Project\Domains\Admin\Code\Domain\Code\ValueObjects\Type;
use Project\Domains\Admin\Code\Domain\Code\ValueObjects\AuthorUuid;
use Project\Domains\Admin\Code\Infrastructure\Account\Adapter\MemberAdapter;
use Project\Domains\Admin\Code\Infrastructure\Account\Adapter\DTOs\Account\VOs\Email;
use Project\Infrastructure\Generators\Contracts\CodeGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use DateTimeImmutable;
use Project\Shared\Domain\Bus\Queue\QueueBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    private const EXPIRED_AT_DATE = '+ 1 hour';

    public function __construct(
        private CodeRepositoryInterface $repository,
        private MemberAdapter $accountAdapter,
        private CodeGeneratorInterface $codeGenerator,
        private QueueBusInterface $queueBus
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
        $this->queueBus->dispatch(new SendEmailQueue($code));
    }
}