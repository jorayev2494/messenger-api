<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Client\Queries\Index;

use Project\Domains\Admin\Client\Application\Client\Queries\Index\Response\Response;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ClientRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Response
    {
        return Response::make(
            $this->repository->paginate()
        );
    }
}