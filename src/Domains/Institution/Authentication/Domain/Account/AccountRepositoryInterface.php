<?php

declare(strict_types=1);

namespace Project\Domains\Institution\Authentication\Domain\Account;

use Project\Domains\Institution\Authentication\Domain\Account\ValueObjects\Email;

interface AccountRepositoryInterface
{
    public function findByEmail(Email $email): ?Account;

    public function save(Account $account): void;
}