<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Queries\Index;

use Project\Domains\Admin\Manager\Application\Manager\Queries\Index\Response\Response;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Response
    {
        return Response::make(
            $this->repository->paginate()
        );
    }
}