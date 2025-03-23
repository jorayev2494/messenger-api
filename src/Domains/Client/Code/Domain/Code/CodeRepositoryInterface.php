<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Domain\Code;

use Project\Domains\Client\Code\Domain\Code\ValueObjects\Type;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\AuthorUuid;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\Value;

interface CodeRepositoryInterface
{
    public function findById(int $id): ?Code;

    public function findByAuthorUuidAndType(AuthorUuid $authorUuid, Type $type): ?Code;

    public function findByValue(Value $value): ?Code;

    public function save(Code $code): void;

    public function delete(Code $code): void;
}