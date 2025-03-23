<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Commands\ChangePermissions;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Admin:Role:ChangePermissionRequestBodySchema',
    required: ['permission_ids']
)]
readonly class Command implements CommandInterface
{
    #[OA\Property(
        type: 'array',
        property: 'permission_ids',
        items: new OA\Items(
            type: 'integer',
            example: 1
        )
    )]
    // #[Assert\NotBlank]
    public array $permissionIds;

    public function __construct(
        public string $uuid,
        array $permissionIds
    ) {
        $this->permissionIds = $permissionIds;
    }
}