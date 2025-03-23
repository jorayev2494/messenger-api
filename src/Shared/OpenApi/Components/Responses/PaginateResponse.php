<?php

declare(strict_types=1);

namespace Project\Shared\OpenApi\Components\Responses;

use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class PaginateResponse extends OA\Response
{
    public function __construct(
        string $dataRef,
        string|object|null $ref = null,
        int|string|null $status = Response::HTTP_OK,
        ?string $description = 'Created response',
        ?array $headers = null,
        OA\MediaType|OA\JsonContent|OA\XmlContent|OA\Attachable|array|null $content = null,
        ?array $links = null,
        // annotation
        ?array $x = null,
        ?array $attachables = null
    )
    {
        parent::__construct(
            response: $status ?? Response::HTTP_OK,
            description: $description ?? 'Paginate response',
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            type: 'integer',
                            example: 1,
                            property: 'current_page',
                        ),
                        new OA\Property(
                            type: 'array',
                            property: 'data',
                            items: new OA\Items(
                                type: 'object',
                                ref: $dataRef
                            )
                        ),
                        new OA\Property(
                            type: 'integer',
                            property: 'next_page',
                            example: 2,
                            nullable: true
                        ),
                        new OA\Property(
                            type: 'string',
                            property: 'next_page_url',
                            example: 'http://127.0.0.1:8088/api/admin/roles?page=2&per_page=15',
                            nullable: true
                        ),
                        new OA\Property(
                            type: 'integer',
                            property: 'last_page',
                            example: 3,
                            nullable: true
                        ),
                        new OA\Property(
                            type: 'string',
                            property: 'last_page_url',
                            example: 'http://127.0.0.1:8088/api/admin/roles?page=3&per_page=15',
                            nullable: true
                        ),
                        new OA\Property(
                            type: 'integer',
                            property: 'per_page',
                            example: 15,
                            nullable: true
                        ),
                        new OA\Property(
                            type: 'integer',
                            property: 'to',
                            example: 15,
                            nullable: true
                        ),
                        new OA\Property(
                            type: 'integer',
                            property: 'total',
                            example: 45,
                            nullable: true
                        ),
                    ]
                )
            )
        );
    }
}