<?php

namespace Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\Contracts;

use Project\Domains\Client\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\Value;

interface CodeApiInterface
{
    public function findByValue(Value $value): ?array;

    public function delete(int $id): void;
}