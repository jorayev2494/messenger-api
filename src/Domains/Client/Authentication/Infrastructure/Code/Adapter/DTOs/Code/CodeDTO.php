<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\DTOs\Code;

use Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\AuthorUuid;
use Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\Type;
use Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\Id;
use Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\Value;
use DateTimeImmutable;

readonly class CodeDTO
{
    private function __construct(
        public Id $id,
        public Value $value,
        public Type $type,
        public AuthorUuid $authorUuid,
        public DateTimeImmutable $expiredAt
    ) { }

    public static function make(Id $id, Value $value, Type $type, AuthorUuid $authorUuid, DateTimeImmutable $expiredAt): self
    {
        return new self($id, $value, $type, $authorUuid, $expiredAt);
    }

    public static function makeFromArray(array $data): self
    {
        [
            'id' => $id,
            'value' => $value,
            'type' => $type,
            'author_uuid' => $authorUuid,
            'expired_at' => $expiredAt,
        ] = $data;

        return self::make(
            Id::fromValue($id),
            Value::fromValue($value),
            Type::fromValue($type),
            AuthorUuid::fromValue($authorUuid),
            (new DateTimeImmutable)->setTimestamp($expiredAt)
        );
    }
}