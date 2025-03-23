<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Queries\Index;

use Project\Domains\Admin\Role\Application\Role\Queries\Index\Response\Response;
use Project\Domains\Admin\Role\Domain\Role\RoleRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Response
    {
        return Response::make(
            $this->repository->paginate()
        );
    }
}