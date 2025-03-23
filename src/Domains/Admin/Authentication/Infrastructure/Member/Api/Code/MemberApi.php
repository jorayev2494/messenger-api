<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Member\Api\Code;

use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Admin\Code\Infrastructure\Account\Adapter\Contracts\MemberApiInterface;

readonly class MemberApi implements MemberApiInterface
{
    public function __construct(
        private MemberRepositoryInterface $repository
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