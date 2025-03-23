<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Profile\Queries\Show;

use Project\Domains\Admin\Profile\Domain\Profile\Exceptions\ProfileNotFoundDomainException;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\Uuid;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\ManagerAdapter;
use Project\Domains\Client\Profile\Application\Profile\Queries\Show\Response\Response;
use Project\Infrastructure\Services\Authentication\Auth;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ManagerAdapter $adapter
    ) { }

    public function __invoke(Query $query): Response
    {
        $profile = $this->adapter->findByUuid(Uuid::fromValue(Auth::manager()->getUuid()->value));

        $profile ?? throw new ProfileNotFoundDomainException();

        return Response::make($profile);
    }
}