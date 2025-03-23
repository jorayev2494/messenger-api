<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandValidate;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Admin:Manager:UpdateRequestBodySchema',
    required: [
        'email',
        'first_name',
        'last_name',
    ]
)]
class Command extends CommandValidate
{
    #[Assert\Uuid]
    #[Assert\NotBlank]
    public string $uuid;

    #[OA\Property(example: 'manager@gmail.com', uniqueItems: true)]
    #[Assert\Email]
    #[Assert\NotBlank]
    public string $email;

    #[OA\Property(property: 'first_name', example: 'Manager')]
    #[Assert\NotBlank]
    public string $firstName;

    #[OA\Property(property: 'last_name', example: 'Managerov')]
    #[Assert\NotBlank]
    public string $lastName;

    public function __construct(
        string $uuid,
        string $email,
        string $firstName,
        string $lastName
    ) {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}