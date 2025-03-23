<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Commands\Login;

use Project\Shared\Domain\Bus\Command\CommandValidate;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends CommandValidate
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $deviceId,
        #[Assert\NotBlank, Assert\Email]
        public readonly string $email,
        #[Assert\NotBlank, Assert\Length(min: 6)]
        public readonly string $password
    ) { }
}