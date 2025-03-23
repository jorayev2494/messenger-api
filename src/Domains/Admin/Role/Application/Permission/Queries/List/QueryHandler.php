<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Permission\Queries\List;

use Project\Domains\Admin\Role\Application\Permission\Queries\List\Response\Response;
use Project\Domains\Admin\Role\Domain\Permission\PermissionCollection;
use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PermissionRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Response
    {
        return Response::make($this->repository->list());
    }
}