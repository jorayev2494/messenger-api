<?php

declare(strict_types=1);

namespace Project\Infrastructure\Generators;

use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid as Uuid;

final class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}