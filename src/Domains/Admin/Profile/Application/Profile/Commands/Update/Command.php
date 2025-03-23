<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Profile\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandValidate;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Admin:Profile:UpdateRequestBodySchema',
    required: [
        'email',
        'first_name',
        'last_name',
    ]
)]
class Command extends CommandValidate
{
    #[OA\Property(example: 'profile@gmail.com', uniqueItems: true)]
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
        string $email,
        string $firstName,
        string $lastName
    ) {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}