<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Member\Queries\GetRole;

use Project\Domains\Admin\Role\Application\Member\Queries\GetRole\Response\Response;
use Project\Domains\Admin\Role\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Member\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private MemberRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Response
    {
        $foundMember = $this->repository->findByUuid(Uuid::fromValue($query->memberUuid));

        $foundMember ?? throw new DomainException('Member not found');

        return Response::make($foundMember->getRole());
    }
}