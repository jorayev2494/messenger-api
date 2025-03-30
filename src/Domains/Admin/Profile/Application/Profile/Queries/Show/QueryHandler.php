<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Profile\Queries\Show;

use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\Uuid;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\ManagerAdapter;
use Project\Domains\Client\Profile\Application\Profile\Queries\Show\Response\Response;
use Project\Infrastructure\Services\Authentication\Auth;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ManagerAdapter $adapter
    ) { }

    public function __invoke(Query $query): Response
    {
        $profile = $this->adapter->findByUuid(Uuid::fromValue(Auth::manager()->getUuid()->value));

        $profile ?? throw new DomainException('Profile not found');

        return Response::make($profile);
    }
}