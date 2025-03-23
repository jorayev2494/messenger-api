<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Client\Queries\Show;

use Project\Domains\Admin\Client\Application\Client\Queries\Show\Response\Response;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ClientRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Response
    {
        $client = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $client ?? throw new DomainException('Client not found');

        return Response::make($client);
    }
}