<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Member\Commands\SetRole;

use Project\Domains\Admin\Role\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Member\ValueObjects\Uuid as MemberUuid;
use Project\Domains\Admin\Role\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $repository,
        private MemberRepositoryInterface $memberRepository
    ) { }

    public function __invoke(Command $command): void
    {
        $foundRole = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $foundRole ?? throw new DomainException('Role not found');

        $foundMember = $this->memberRepository->findByUuid(MemberUuid::fromValue($command->memberUuid));

        $foundMember ?? throw new DomainException('Member not found');

        $foundMember->changeRole($foundRole);

        $this->memberRepository->save($foundMember);
    }
}