<?php

namespace Project\Shared\Contracts;

interface NullableInterface
{
    public function isNull(): bool;

    public function isNotNull(): bool;
}