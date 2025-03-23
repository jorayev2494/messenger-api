<?php

namespace Project\Infrastructure\Services\Authentication\Contracts;

use Doctrine\Common\Collections\Collection;
use Project\Infrastructure\Services\Authentication\Entity\BaseDevice;

interface DeviceableInterface
{
    /**
     * @return array<array-key, BaseDevice>
     */
    public function getDevices(): array;

    public function addDevice(BaseDevice $device): void;

    public function removeDevice(BaseDevice $device): void;
}