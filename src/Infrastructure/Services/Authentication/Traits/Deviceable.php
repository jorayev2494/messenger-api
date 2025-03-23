<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication\Traits;

use Project\Infrastructure\Services\Authentication\Entity\BaseDevice;

trait Deviceable
{
    public function getDevices(): array
    {
        return $this->devices->toArray();
    }

    public function addDevice(BaseDevice $device): void
    {
        $this->devices->add($device);
        $device->setAuthor($this);
    }

    public function removeDevice(BaseDevice $device): void
    {
        if ($this->devices->contains($device)) {
            $this->devices->removeElement($device);
        }
    }
}