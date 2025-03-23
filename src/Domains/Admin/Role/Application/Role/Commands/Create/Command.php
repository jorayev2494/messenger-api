<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Admin:Role:CreateRequestBodySchema',
    required: [
        'value',
    ]
)]
readonly class Command implements CommandInterface
{
    #[OA\Property(example: 'Admin')]
    #[Assert\NotBlank]
    public string $value;

    #[OA\Property(example: 'Admin description')]
    #[Assert\NotBlank]
    public ?string $description;

    #[OA\Property(property: 'is_super_admin', example: true, enum: [true, false], default: false)]
    public bool $isSuperAdmin;

    public function __construct(
        public string $uuid,
        string $value,
        ?string $description,
        bool $isSuperAdmin = false
    ) {
        $this->value = $value;
        $this->description = $description;
        $this->isSuperAdmin = $isSuperAdmin;
    }
}