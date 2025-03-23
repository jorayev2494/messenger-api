<?php

namespace Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\Contracts;

interface ManagerApiInterface
{
    public function findByUuid(string $uuid): ?array;

    public function update(string $uuid, string $email, string $firstName, string $lastName): void;
}