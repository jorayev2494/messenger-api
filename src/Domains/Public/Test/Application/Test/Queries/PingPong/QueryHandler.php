<?php

declare(strict_types=1);

namespace Project\Domains\Public\Test\Application\Test\Queries\PingPong;

use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\Bus\Query\QueryInterface;

readonly class QueryHandler implements QueryHandlerInterface
{

    public function __invoke(QueryInterface $query): mixed
    {
        return [
            'message' => 'pong',
        ];
    }
}