<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Account\Repositories\Doctrine;

use Project\Domains\Client\Authentication\Domain\Account\Account;
use Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Email;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;

class AccountRepository extends BaseEntityRepository implements AccountRepositoryInterface
{
    protected function getEntity(): string
    {
        return Account::class;
    }

    public function findByUuid(Uuid $uuid): ?Account
    {
        return $this->entityRepository->find($uuid);
    }

    public function findByEmail(Email $email): ?Account
    {
        return $this->entityRepository->createQueryBuilder('a')
            ->where('a.email = :email')
            ->setParameter('email', $email->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Account $account): void
    {
        $this->entityRepository->getEntityManager()->persist($account);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Account $account): void
    {
        $this->entityRepository->getEntityManager()->remove($account);
        $this->entityRepository->getEntityManager()->flush();
    }
}