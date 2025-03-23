<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Queries\Show;

use Project\Domains\Admin\Manager\Application\Manager\Queries\Show\Response\Response;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Response
    {
        $manager = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $manager ?? throw new DomainException('Manager not found');

        return Response::make($manager);
    }
}