<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Domain\Code\ValueObjects;

use Project\Domains\Client\Code\Domain\Code\Enums\Type as TypeEnum;

readonly class Type
{
    private function __construct(
        public TypeEnum $value
    ) { }

    public function make(TypeEnum $type): self
    {
        return new self($type);
    }

    public static function fromValue(string $value): self
    {
        return new self(TypeEnum::from($value));
    }
}