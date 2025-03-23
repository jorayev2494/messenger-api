<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Presentation\Http\API\REST\Controllers;

use Illuminate\Http\Request;
use Project\Domains\Admin\Role\Application\Permission\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Role\Application\Permission\Commands\Create\Command as CreateCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\OpenApi\Components as OAC;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

readonly class PermissionController
{
    public function __construct(
        private ResponseInterface $response,
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
    ) { }

    #[OA\Get(
        path: '/roles/permissions',
        summary: 'Load permissions',
        tags: [
            'Permissions'
        ],
        security: [
            ['authBearerToken' => []],
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Permission list response',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'array',
                        items: new OA\Items(
                            ref: '#/components/schemas/Admin:Role:Permission:CreateResponseScheme'
                        )
                    )
                )
            )
        ]
    )]
    public function list(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ListQuery()
            )
        );
    }

    #[OA\Post(
        path: '/roles/permissions',
        summary: 'Create permission',
        tags: [
            'Permissions'
        ],
        security: [
            ['authBearerToken' => []],
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/Admin:Role:Permission:CreateRequestBodyScheme'
            )
        ),
        responses: [
            new OAC\Responses\CreatedResponse(),
        ]
    )]
    public function create(Request $request): Response
    {
        $this->commandBus->dispatch(
            new CreateCommand(
                $request->get('label') ?? '',
                $request->get('resource') ?? '',
                $request->get('action') ?? ''
            )
        );

        return $this->response->noContent(Response::HTTP_CREATED);
    }
}