<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Application\Code\Commands\Create;

use Project\Domains\Client\Code\Domain\Code\Enums\Type;
use Project\Shared\Domain\Bus\Command\CommandValidate;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends CommandValidate
{
    public function __construct(
        #[Assert\NotBlank, Assert\Email] public string $email,
        #[Assert\NotBlank, Assert\Choice(callback: 'getTypes')] public string $type
    ) { }

    public static function getTypes(): array
    {
        return array_map(static fn (Type $type): string => $type->value, Type::cases());
    }
}