<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Member\Commands\SetRole;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class Command implements CommandInterface
{
    public function __construct(
        #[Assert\NotBlank] public string $uuid,
        #[Assert\NotBlank] public string $memberUuid
    ) { }
}