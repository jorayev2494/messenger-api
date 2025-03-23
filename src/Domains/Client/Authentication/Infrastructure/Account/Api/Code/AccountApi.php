<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Account\Api\Code;

use Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Email;
use Project\Domains\Client\Code\Infrastructure\Account\Adapter\Contracts\AccountApiInterface;

readonly class AccountApi implements AccountApiInterface
{
    public function __construct(
        private AccountRepositoryInterface $repository
    ) { }

    public function findByEmail(string $email): ?array
    {
        $account = $this->repository->findByEmail(Email::fromValue($email));

        if ($account === null) {
            return null;
        }

        return [
            'uuid' => $account->getUuid()->value,
            'email' => $account->getEmail()->value,
        ];
    }
}