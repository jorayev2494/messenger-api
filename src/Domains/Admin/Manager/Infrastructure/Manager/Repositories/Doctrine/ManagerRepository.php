<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;

class ManagerRepository extends BaseEntityRepository implements ManagerRepositoryInterface
{
    protected function getEntity(): string
    {
        return Manager::class;
    }

    public function get(): array
    {
        return $this->entityRepository->createQueryBuilder('m')
            ->select([
                'm',
            ])
            ->getQuery()
            ->getResult();
    }

    public function paginate(): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('m');

        return $this->paginator($query->getQuery());
    }

    public function findByUuid(Uuid $uuid): ?Manager
    {
        return $this->entityRepository->find($uuid);
    }

    public function findByEmail(Email $email): ?Manager
    {
        return $this->entityRepository->createQueryBuilder('m')
            ->where('m.email = :email')
            ->setParameter('email', $email->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Manager $manager): void
    {
        $this->entityRepository->getEntityManager()->persist($manager);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Manager $manager): void
    {
        $this->entityRepository->getEntityManager()->remove($manager);
        $this->entityRepository->getEntityManager()->flush();
    }
}