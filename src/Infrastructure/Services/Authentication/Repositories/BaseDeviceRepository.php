<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication\Repositories;

use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Infrastructure\Services\Authentication\Entity\BaseDevice;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;

abstract class BaseDeviceRepository extends BaseEntityRepository implements DeviceRepositoryInterface
{
    public function findByDeviceIdAndRefreshToken(string $deviceId, string $refreshToken): ?BaseDevice
    {
        return $this->entityRepository->findOneBy([
            'deviceId' => $deviceId,
            'refreshToken' => $refreshToken,
        ]);
    }

    public function save(BaseDevice $device): void
    {
        $this->entityRepository->getEntityManager()->persist($device);
        $this->entityRepository->getEntityManager()->flush();
    }
}