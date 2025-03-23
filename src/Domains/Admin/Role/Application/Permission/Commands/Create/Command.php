<?php

namespace Project\Domains\Admin\Role\Application\Permission\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Admin:Role:Permission:CreateRequestBodyScheme',
    required: [
        'label',
        'resource',
        'action',
    ]
)]
readonly class Command implements CommandInterface
{
    #[OA\Property(example: 'Manager create')]
    #[Assert\NotBlank]
    public string $label;

    #[OA\Property(example: 'manager')]
    #[Assert\NotBlank]
    public string $resource;

    #[OA\Property(example: 'create')]
    #[Assert\NotBlank]
    public string $action;

    public function __construct(
        string $label,
        string $resource,
        string $action
    ) {
        $this->label = $label;
        $this->resource = $resource;
        $this->action = $action;
    }
}
