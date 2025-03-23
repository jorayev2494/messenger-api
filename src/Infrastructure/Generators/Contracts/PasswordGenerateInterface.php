<?php

namespace Project\Infrastructure\Generators\Contracts;

interface PasswordGenerateInterface
{
    public function generate(int $length = 6): string;
}