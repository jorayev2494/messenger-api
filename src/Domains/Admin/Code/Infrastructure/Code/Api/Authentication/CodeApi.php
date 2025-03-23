<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Infrastructure\Code\Api\Authentication;

use Project\Domains\Admin\Authentication\Infrastructure\Code\Adapter\Contracts\CodeApiInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\Value;
use Project\Domains\Admin\Code\Application\Code\Commands\Delete\Command;
use Project\Domains\Admin\Code\Domain\Code\CodeRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

readonly class CodeApi implements CodeApiInterface
{
    public function __construct(
        private CodeRepositoryInterface $repository
    ) { }

    public function findByValue(Value $value): ?array
    {
        $code = $this->repository->findByValue(\Project\Domains\Admin\Code\Domain\Code\ValueObjects\Value::fromValue($value->value));

        if ($code === null) {
            return null;
        }

        return [
            'id' => $code->getId(),
            'value' => $code->getValue()->value,
            'type' => $code->getType()->value->value,
            'author_uuid' => $code->getAuthorUuid()->value,
            'expired_at' => $code->getExpiredAt()->getTimestamp(),
        ];
    }

    public function delete(int $id): void
    {
        resolve(CommandBusInterface::class)->dispatch(new Command($id));
    }
}