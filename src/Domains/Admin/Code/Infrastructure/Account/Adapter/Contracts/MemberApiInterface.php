<?php

namespace Project\Domains\Admin\Code\Infrastructure\Account\Adapter\Contracts;

interface MemberApiInterface
{
    public function findByEmail(string $email): ?array;
}