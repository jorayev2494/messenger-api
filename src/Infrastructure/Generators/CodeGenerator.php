<?php

declare(strict_types=1);

namespace Project\Infrastructure\Generators;

use Project\Infrastructure\Generators\Contracts\CodeGeneratorInterface;

final class CodeGenerator implements CodeGeneratorInterface
{
    public function generate(int $min = 000000, int $max = 999999): int
    {
        return random_int($min, $max);
    }
}