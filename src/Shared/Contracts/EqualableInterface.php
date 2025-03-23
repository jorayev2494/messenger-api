<?php

namespace Project\Shared\Contracts;

interface EqualableInterface
{
    public function isEqual(self $other): bool;

    public function isNotEqual(self $other): bool;
}