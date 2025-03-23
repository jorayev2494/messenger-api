<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Queries\Index\Response;

use OpenApi\Attributes as OA;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Shared\Contracts\ArrayableInterface;

#[OA\Schema(schema: 'Admin:Manager:IndexResponseSchema')]
readonly class ManagerResponse implements ArrayableInterface
{
    #[OA\Property(example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8', uniqueItems: true)]
    protected string $uuid;

    #[OA\Property(example: 'manager@gmail.com', uniqueItems: true)]
    protected string $email;

    #[OA\Property(property: 'first_name', example: 'Manager')]
    protected ?string $firstName;

    #[OA\Property(property: 'last_name', example: 'Managerov')]
    protected ?string $lastName;

    private function __construct(Manager $manager)
    {
        $this->uuid = $manager->getUuid()->value;
        $this->email = $manager->getEmail()->value;
        $this->firstName = $manager->getFirstName()->value;
        $this->lastName = $manager->getLastName()->value;
    }

    public static function make(Manager $manager): self
    {
        return new self($manager);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ];
    }
}
