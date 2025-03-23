<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Presentation\Http\API\REST\Controllers;

use OpenApi\Attributes as OA;
use Project\Domains\Admin\Role\Application\Member\Commands\SetRole\Command as SetRoleCommand;
use Project\Domains\Admin\Role\Application\Member\Queries\GetRole\Query;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\OpenApi\Components as OAC;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class MemberController
{
    public function __construct(
        private ResponseInterface $response,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) { }

    #[OA\Put(
        path: '/roles/{uuid}/members/{member_uuid}',
        summary: 'Role set to member ',
        tags: ['Roles'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Paths\UuidParameter(),
            new OAC\Parameters\Paths\UuidParameter(name: 'member_uuid'),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Role set to member response'
            ),
        ]
    )]
    public function setToMember(string $uuid, string $memberUuid): Response
    {
        $this->commandBus->dispatch(
            new SetRoleCommand(
                $uuid,
                $memberUuid
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    #[OA\Get(
        path: '/roles/members/{member_uuid}',
        summary: 'Get role',
        tags: ['Roles'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Paths\UuidParameter(name: 'member_uuid'),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Get role response'
            ),
        ]
    )]
    public function getRole(string $memberUuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new Query($memberUuid)
            )
        );
    }
}