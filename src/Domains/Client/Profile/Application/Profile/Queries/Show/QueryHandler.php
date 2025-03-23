<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Application\Profile\Queries\Show;

use Project\Domains\Client\Profile\Application\Profile\Queries\Show\Response\Response;
use Project\Infrastructure\Services\Authentication\Auth;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\Bus\Query\QueryInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct() { }

    public function __invoke(Query $query): Response
    {
        $account = Auth::client();

        return Response::make([
            'uuid' => $account->getUuid()->value,
            'email' => $account->getEmail()->value,
        ]);
    }
}