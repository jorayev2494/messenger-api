<?php

namespace Project\Infrastructure\Generators\Contracts;

interface UuidGeneratorInterface
{
    public function generate(): string;
}