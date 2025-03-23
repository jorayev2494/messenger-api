<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Presentation\Http\API\REST\Controllers;

use Illuminate\Http\Request;
use Project\Domains\Admin\Role\Application\Role\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Role\Application\Role\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Role\Application\Role\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Role\Application\Role\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Role\Application\Role\Commands\Delete\Command as DeleteCommand;
use Project\Domains\Admin\Role\Application\Role\Commands\ChangePermissions\Command as ChangePermissionsCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use Project\Shared\OpenApi\Components as OAC;

readonly class RoleController
{
    public function __construct(
        private ResponseInterface $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) { }

    #[OA\Get(
        path: '/roles',
        summary: 'Role paginate',
        tags: ['Roles'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Queries\PageParameter(),
            new OAC\Parameters\Queries\PerPageParameter(),
        ],
        responses: [
            new OAC\Responses\PaginateResponse(
                dataRef: '#/components/schemas/Admin:Role:IndexResponseScheme'
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new IndexQuery()
            )
        );
    }

    #[OA\Post(
        path: '/roles',
        summary: 'Create role',
        tags: ['Roles'],
        security: [
            ['authBearerToken' => []],
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/Admin:Role:CreateRequestBodySchema',
            )
        ),
        responses: [
            new OAC\Responses\CreatedResponse(
                description: 'Role Created Response'
            ),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid = $this->uuidGenerator->generate(),
                $request->get('value') ?? '',
                $request->get('description'),
                $request->boolean('is_super_admin')
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }


    #[OA\Get(
        path: '/roles/{uuid}',
        summary: 'Show role',
        tags: ['Roles'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Paths\UuidParameter()
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Show role response',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Admin:Role:ShowResponseSchema'
                )
            ),
        ]
    )]
    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery($uuid)
            )
        );
    }

    #[OA\Put(
        path: '/roles/{uuid}',
        summary: 'Update role',
        tags: ['Roles'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Paths\UuidParameter(),
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/Admin:Role:UpdateRequestBodySchema'
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Role updated response'
            ),
        ]
    )]
    public function update(Request $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('value') ?? '',
                $request->get('description'),
                $request->boolean('is_super_admin')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    #[OA\Delete(
        path: '/roles/{uuid}',
        summary: 'Delete role',
        tags: ['Roles'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Paths\UuidParameter(),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_NO_CONTENT,
                description: 'Role deleted response'
            ),
        ]
    )]
    public function destroy(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new DeleteCommand($uuid)
        );

        return $this->response->noContent();
    }

    #[OA\Post(
        path: '/roles/{uuid}/permissions',
        summary: 'Role set permissions',
        tags: ['Roles'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Paths\UuidParameter(),
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/Admin:Role:ChangePermissionRequestBodySchema',
            )
        ),
        responses: [
            new OAC\Responses\CreatedResponse(
                description: 'Role Created Response'
            ),
        ]
    )]
    public function changePermissions(Request $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new ChangePermissionsCommand(
                $uuid,
                $request->get('permission_ids')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}