<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication\Services;

use Project\Domains\Admin\Authentication\Domain\Member\Member;
use Project\Domains\Client\Authentication\Domain\Account\Account;
use Project\Domains\Admin\Authentication\Domain\Device\Device as ManagerDevice;
use Project\Domains\Client\Authentication\Domain\Device\Device as ClientDevice;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Infrastructure\Services\Authentication\Contracts\DeviceableInterface;
use Project\Infrastructure\Services\Authentication\Entity\BaseDevice;
use Project\Infrastructure\Services\Authentication\Services\Contracts\DeviceServiceInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

readonly class DeviceService implements DeviceServiceInterface
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private TokenGeneratorInterface $tokenGenerator
    ) { }

    public function addDeviceToAccount(DeviceableInterface $deviceable, string $deviceId): BaseDevice
    {
        $refreshToken = $this->tokenGenerator->generate();
        $device = $this->findDeviceByDeviceId($deviceable, $deviceId);

        if ($device === null) {
            $deviceable->addDevice($device = $this->deviceFactory($deviceable, $refreshToken, $deviceId));
        } else {
            $device->setRefreshToken($refreshToken);
        }

        return $device;
    }

    public function removeDeviceFromAccount(DeviceableInterface $deviceable, string $deviceId): void
    {
        $device = $this->findDeviceByDeviceId($deviceable, $deviceId);

        if ($device !== null) {
            $deviceable->removeDevice($device);
        }
    }

    private function deviceFactory(DeviceableInterface $deviceable, string $refreshToken, string $deviceId): BaseDevice
    {
        $uuid = $this->uuidGenerator->generate();

        return match (true) {
            $deviceable instanceof Member => ManagerDevice::fromPrimitives($uuid, $refreshToken, $deviceId),
            $deviceable instanceof Account => ClientDevice::fromPrimitives($uuid, $refreshToken, $deviceId),
            default => throw new BadRequestException('Unknown account for add device')
        };
    }

    private function findDeviceByDeviceId(DeviceableInterface $deviceable, string $deviceId): ?BaseDevice
    {
        foreach ($deviceable->getDevices() as $device) {
            if ($device->getDeviceId() === $deviceId) {
                return $device;
            }
        }

        return null;
    }
}