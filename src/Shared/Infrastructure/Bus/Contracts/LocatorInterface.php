<?php

namespace Project\Shared\Infrastructure\Bus\Contracts;

interface LocatorInterface
{
    public function all(): array;
}