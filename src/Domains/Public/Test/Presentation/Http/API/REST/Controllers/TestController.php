<?php

declare(strict_types=1);

namespace Project\Domains\Public\Test\Presentation\Http\API\REST\Controllers;

use Project\Domains\Public\Test\Application\Test\Queries\PingPong\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class TestController
{
    public function __construct(
        private ResponseInterface $response,
        private QueryBusInterface $queryBus
    ) { }

    public function ping(): Response
    {
        return $this->response->json(
            $this->queryBus->ask(new Query())
        );
    }
}