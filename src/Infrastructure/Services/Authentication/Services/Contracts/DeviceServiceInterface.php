<?php

namespace Project\Infrastructure\Services\Authentication\Services\Contracts;

use Project\Infrastructure\Services\Authentication\Contracts\DeviceableInterface;
use Project\Infrastructure\Services\Authentication\Entity\BaseDevice;

interface DeviceServiceInterface
{
    public function addDeviceToAccount(DeviceableInterface $deviceable, string $deviceId): BaseDevice;

    public function removeDeviceFromAccount(DeviceableInterface $deviceable, string $deviceId): void;
}