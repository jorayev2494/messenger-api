<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Infrastructure\Account\Adapter;

use Project\Domains\Admin\Code\Infrastructure\Account\Adapter\Contracts\MemberApiInterface;
use Project\Domains\Admin\Code\Infrastructure\Account\Adapter\DTOs\Account\AccountDTO;
use Project\Domains\Admin\Code\Infrastructure\Account\Adapter\DTOs\Account\VOs\Email;

readonly class MemberAdapter
{
    public function __construct(
        private MemberApiInterface $api
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