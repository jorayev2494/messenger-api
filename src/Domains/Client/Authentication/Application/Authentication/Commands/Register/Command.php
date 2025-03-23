<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Commands\Register;

use Project\Infrastructure\Services\Authentication\ValueObjects\PasswordValueObject;
use Project\Shared\Domain\Bus\Command\CommandValidate;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends CommandValidate
{
    public readonly string $uuid;

    #[Assert\NotBlank]
    #[Assert\Email]
    public readonly string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: PasswordValueObject::LENGTH)]
    public readonly string $password;

    #[Assert\NotBlank]
    public readonly string $passwordConfirmation;

    public function __construct(
        string $uuid,
        string $email,
        string $password,
        string $passwordConfirmation
    ) {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }

    #[Assert\IsTrue(message: 'The password cannot match password confirmation')]
    public function isPasswordConfirmation(): bool
    {
        return $this->password === $this->passwordConfirmation;
    }
}