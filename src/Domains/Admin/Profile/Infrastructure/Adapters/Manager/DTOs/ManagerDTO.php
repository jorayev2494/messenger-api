<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs;

use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\Email;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\FirstName;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\LastName;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\Uuid;

readonly class ManagerDTO
{
    private function __construct(
        public Uuid $uuid,
        public Email $email,
        public FirstName $firstName,
        public LastName $lastName
    ) { }

    public static function make(
        Uuid $uuid,
        Email $email,
        FirstName $firstName,
        LastName $lastName
    ): self
    {
        return new self($uuid, $email, $firstName, $lastName);
    }
}