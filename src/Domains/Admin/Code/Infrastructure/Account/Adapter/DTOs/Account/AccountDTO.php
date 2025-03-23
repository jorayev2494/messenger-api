<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Infrastructure\Account\Adapter\DTOs\Account;

use Project\Domains\Client\Code\Infrastructure\Account\Adapter\DTOs\Account\VOs\Email;
use Project\Domains\Client\Code\Infrastructure\Account\Adapter\DTOs\Account\VOs\Uuid;

readonly class AccountDTO
{
    private function __construct(
        public Uuid $uuid,
        public Email $email
    ) { }

    public static function make(Uuid $uuid, Email $email): self
    {
        return new self($uuid, $email);
    }

    public static function makeFromArray(array $data): self
    {
        [
            'uuid' => $uuid,
            'email' => $email,
        ] = $data;

        return self::make(Uuid::fromValue($uuid), Email::fromValue($email));
    }
}