<?php

namespace Project\Domains\Admin\Authentication\Infrastructure\Device\Repositories\Doctrine;

use Project\Domains\Admin\Authentication\Domain\Device\Device;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Infrastructure\Services\Authentication\Repositories\BaseDeviceRepository;

class DeviceRepository extends BaseDeviceRepository implements DeviceRepositoryInterface
{
    protected function getEntity(): string
    {
        return Device::class;
    }
}