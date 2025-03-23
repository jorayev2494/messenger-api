<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\RefreshToken;

use Project\Shared\Domain\Bus\Command\CommandValidate;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends CommandValidate
{
    public function __construct(
        #[Assert\NotBlank] public readonly string $deviceId,
        #[Assert\NotBlank] public readonly string $refreshToken
    ) { }
}