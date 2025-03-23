<?php

namespace Project\Infrastructure\Services\Authentication\Contracts;

interface DeviceInterface
{
    public function getRefreshToken(): string;
}