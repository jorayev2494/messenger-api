<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Member\Repositories\Doctrine;

use Project\Domains\Admin\Authentication\Domain\Member\Member;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;

class MemberRepository extends BaseEntityRepository implements MemberRepositoryInterface
{
    protected function getEntity(): string
    {
        return Member::class;
    }

    public function findByUuid(Uuid $uuid): ?Member
    {
        return $this->entityRepository->find($uuid);
    }

    public function findByEmail(Email $email): ?Member
    {
        return $this->entityRepository->createQueryBuilder('m')
            ->where('m.email = :email')
            ->setParameter('email', $email->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Member $member): void
    {
        $this->entityRepository->getEntityManager()->persist($member);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete($member): void
    {
        $this->entityRepository->getEntityManager()->remove($member);
        $this->entityRepository->getEntityManager()->flush();
    }
}