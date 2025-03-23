<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Queries\Show;

use Project\Domains\Admin\Role\Application\Role\Queries\Show\Response\Response;
use Project\Domains\Admin\Role\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Response
    {
        $role = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $role ?? throw new DomainException('Role not found');

        return Response::make($role);
    }
}