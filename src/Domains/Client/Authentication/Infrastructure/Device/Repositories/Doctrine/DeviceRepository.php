<?php

namespace Project\Domains\Client\Authentication\Infrastructure\Device\Repositories\Doctrine;

use Project\Domains\Client\Authentication\Domain\Device\Device;
use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Infrastructure\Services\Authentication\Entity\BaseDevice;
use Project\Infrastructure\Services\Authentication\Repositories\BaseDeviceRepository;

class DeviceRepository extends BaseDeviceRepository implements DeviceRepositoryInterface
{
    protected function getEntity(): string
    {
        return Device::class;
    }
}