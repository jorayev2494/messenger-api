<?php

namespace Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine;

use Project\Domains\Admin\Role\Domain\Role\Role;
use Project\Domains\Admin\Role\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\IsSuperAdmin;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;

class RoleRepository extends BaseEntityRepository implements RoleRepositoryInterface
{
    protected function getEntity(): string
    {
        return Role::class;
    }

    public function paginate(): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('r');

        return $this->paginator($query);
    }

    public function findByUuid(Uuid $uuid): ?Role
    {
        return $this->entityRepository->find($uuid);
    }

    public function findSuperAdmin(): ?Role
    {
        return $this->entityRepository->createQueryBuilder('r')
            ->where('r.isSuperAdmin = :isSuperAdmin')
            ->setParameter('isSuperAdmin', true)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Role $role): void
    {
        $this->entityRepository->getEntityManager()->persist($role);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Role $role): void
    {
        $this->entityRepository->getEntityManager()->remove($role);
        $this->entityRepository->getEntityManager()->flush();
    }
}