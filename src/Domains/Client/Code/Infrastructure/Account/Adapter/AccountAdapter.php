<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Infrastructure\Account\Adapter;

use Project\Domains\Client\Code\Infrastructure\Account\Adapter\Contracts\AccountApiInterface;
use Project\Domains\Client\Code\Infrastructure\Account\Adapter\DTOs\Account\AccountDTO;
use Project\Domains\Client\Code\Infrastructure\Account\Adapter\DTOs\Account\VOs\Email;

readonly class AccountAdapter
{
    public function __construct(
        private AccountApiInterface $api
    ) { }

    public function findByEmail(Email $email): ?AccountDTO
    {
        $account = $this->api->findByEmail($email->value);

        if ($account === null) {
            return null;
        }

        return AccountDTO::makeFromArray($account);
    }
}