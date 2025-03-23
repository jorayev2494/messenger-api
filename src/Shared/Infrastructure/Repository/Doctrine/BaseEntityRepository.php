<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Project\Shared\Infrastructure\Repository\Contracts\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\PaginatorHttpQueryParams;

abstract class BaseEntityRepository extends EntityRepository
{
    protected EntityRepository $entityRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->initRepository($entityManager);
    }

    private function initRepository(EntityManagerInterface $entityManager): void
    {
        $this->entityRepository = $entityManager->getRepository($this->getEntity());
    }

    abstract protected function getEntity(): string;

    protected function paginator(QueryBuilder|Query $query, bool $fetchJoinCollection = true, bool $outputWalkers = true): Paginator
    {
        return new Paginator($query, $fetchJoinCollection, $outputWalkers);
    }

    public function flush(): void
    {
        $this->entityRepository->getEntityManager()->flush();
    }
}