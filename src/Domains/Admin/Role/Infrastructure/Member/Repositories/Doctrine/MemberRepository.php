<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Member\Repositories\Doctrine;

use Project\Domains\Admin\Role\Domain\Member\Member;
use Project\Domains\Admin\Role\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Member\ValueObjects\Uuid;
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

    public function save(Member $member): void
    {
        $this->entityRepository->getEntityManager()->persist($member);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Member $member): void
    {
        $this->entityRepository->getEntityManager()->remove($member);
        $this->entityRepository->getEntityManager()->flush();
    }
}