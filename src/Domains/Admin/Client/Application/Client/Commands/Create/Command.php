<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Client\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandValidate;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Admin:Client:CreateRequestBodySchema',
    required: [
        'email',
    ]
)]
class Command extends CommandValidate
{
    #[Assert\Uuid]
    #[Assert\NotBlank]
    public string $uuid;

    #[OA\Property(example: 'client@gmail.com', uniqueItems: true)]
    #[Assert\Email]
    #[Assert\NotBlank]
    public string $email;

    #[OA\Property(property: 'first_name', example: 'Client')]
    #[Assert\NotBlank]
    public string $firstName;

    #[OA\Property(property: 'last_name', example: 'Clientov')]
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