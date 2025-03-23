<?php

namespace Project\Domains\Client\Authentication\Domain\Device;

use Project\Infrastructure\Services\Authentication\Entity\BaseDevice;

interface DeviceRepositoryInterface
{
    public function findByDeviceIdAndRefreshToken(string $deviceId, string $refreshToken): ?BaseDevice;

    public function save(Device $device): void;
}