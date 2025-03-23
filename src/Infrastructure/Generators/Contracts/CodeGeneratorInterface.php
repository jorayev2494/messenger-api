<?php

namespace Project\Infrastructure\Generators\Contracts;

interface CodeGeneratorInterface
{
    public function generate(int $min = 000000, int $max = 999999): int;
}