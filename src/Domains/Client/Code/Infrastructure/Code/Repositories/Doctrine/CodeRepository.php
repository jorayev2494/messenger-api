<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine;

use Project\Domains\Client\Code\Domain\Code\Code;
use Project\Domains\Client\Code\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\Type;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\AuthorUuid;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\Value;

class CodeRepository extends BaseEntityRepository implements CodeRepositoryInterface
{
    protected function getEntity(): string
    {
        return Code::class;
    }

    public function findById(int $id): ?Code
    {
        return $this->entityRepository->find($id);
    }

    public function findByAuthorUuidAndType(AuthorUuid $authorUuid, Type $type): ?Code
    {
        return $this->entityRepository->createQueryBuilder('c')
            ->where('c.authorUuid = :authorUuid')
            ->andWhere('c.type = :type')
            ->setParameter('authorUuid', $authorUuid)
            ->setParameter('type', $type->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByValue(Value $value): ?Code
    {
        return $this->entityRepository->createQueryBuilder('c')
            ->where('c.value = :value')
            ->setParameter('value', $value->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Code $code): void
    {
        $this->entityRepository->getEntityManager()->persist($code);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Code $code): void
    {
        $this->entityRepository->getEntityManager()->remove($code);
        $this->entityRepository->getEntityManager()->flush();
    }
}