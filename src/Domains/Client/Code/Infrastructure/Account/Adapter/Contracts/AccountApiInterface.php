<?php

namespace Project\Domains\Client\Code\Infrastructure\Account\Adapter\Contracts;

interface AccountApiInterface
{
    public function findByEmail(string $email): ?array;
}