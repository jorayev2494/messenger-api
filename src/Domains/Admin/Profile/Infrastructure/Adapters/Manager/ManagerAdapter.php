<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager;

use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\Contracts\ManagerApiInterface;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\ManagerDTO;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\Email;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\FirstName;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\LastName;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\Uuid;

readonly class ManagerAdapter
{
    public function __construct(
        private ManagerApiInterface $api
    ) { }

    public function findByUuid(Uuid $uuid): ?ManagerDTO
    {
        $manager = $this->api->findByUuid($uuid->value);

        if ($manager === null) {
            return null;
        }

        [
            'uuid' => $mUuid,
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ] = $manager;

        return ManagerDTO::make(
            Uuid::fromValue($mUuid),
            Email::fromValue($email),
            FirstName::fromValue($firstName),
            LastName::fromValue($lastName)
        );
    }

    public function update(Uuid $uuid, Email $email, FirstName $firstName, LastName $lastName): void
    {
        $this->api->update($uuid->value, $email->value, $firstName->value, $lastName->value);
    }
}