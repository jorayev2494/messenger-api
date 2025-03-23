<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Account;

use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Uuid;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Email;

interface AccountRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Account;

    public function findByEmail(Email $email): ?Account;

    public function save(Account $account): void;

    public function delete(Account $account): void;
}