<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Commands\Delete;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

readonly class Command implements CommandInterface
{
    #[Assert\Uuid]
    #[Assert\NotBlank]
    public string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }
}