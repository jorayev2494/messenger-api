<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication\DTOs;

readonly class CredentialsDTO
{
    private function __construct(
        public string $email,
        public string $password
    ) { }

    public static function make(string $email, string $password): self
    {
        return new self($email, $password);
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}