<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine;

use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;
use Project\Domains\Admin\Role\Domain\Permission\PermissionCollection;

class PermissionRepository extends BaseEntityRepository implements PermissionRepositoryInterface
{
    protected function getEntity(): string
    {
        return Permission::class;
    }

    public function list(): array
    {
        return $this->entityRepository->createQueryBuilder('p')
            ->getQuery()
            ->getResult();
    }

    public function findManyByIds(array $permissionIds): PermissionCollection
    {
        $query = $this->entityRepository->createQueryBuilder('p')
            ->distinct()
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $permissionIds);

        return PermissionCollection::make($query->getQuery()->getResult());
    }

    public function save(Permission $permission): void
    {
        $this->entityRepository->getEntityManager()->persist($permission);
        $this->entityRepository->getEntityManager()->flush();
    }
}