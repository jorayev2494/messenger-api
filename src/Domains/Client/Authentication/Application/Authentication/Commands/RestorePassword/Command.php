<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Commands\RestorePassword;

use Project\Infrastructure\Services\Authentication\ValueObjects\PasswordValueObject;
use Project\Shared\Domain\Bus\Command\CommandValidate;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends CommandValidate
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly int $code,
        #[Assert\NotBlank, Assert\Length(min: PasswordValueObject::LENGTH)]
        public readonly string $password,
        #[Assert\NotBlank]
        public readonly string $passwordConfirmation
    ) { }

    #[Assert\IsTrue(message: 'The password cannot match password confirmation')]
    public function isPasswordConfirmation(): bool
    {
        return $this->password === $this->passwordConfirmation;
    }
}