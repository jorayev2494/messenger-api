<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine;

use Project\Domains\Admin\Client\Domain\Client\Client;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\Email;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;

class ClientRepository extends BaseEntityRepository implements ClientRepositoryInterface
{
    protected function getEntity(): string
    {
        return Client::class;
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

    public function findByUuid(Uuid $uuid): ?Client
    {
        return $this->entityRepository->find($uuid);
    }

    public function findByEmail(Email $email): ?Client
    {
        return $this->entityRepository->createQueryBuilder('m')
            ->where('m.email = :email')
            ->setParameter('email', $email->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Client $client): void
    {
        $this->entityRepository->getEntityManager()->persist($client);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Client $client): void
    {
        $this->entityRepository->getEntityManager()->remove($client);
        $this->entityRepository->getEntityManager()->flush();
    }
}