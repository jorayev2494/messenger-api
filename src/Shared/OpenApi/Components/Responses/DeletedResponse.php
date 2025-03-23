<?php

declare(strict_types=1);

namespace Project\Shared\OpenApi\Components\Responses;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class DeletedResponse extends OA\Response
{
    public function __construct(
        string|object|null $ref = null,
        int|string|null $status = Response::HTTP_CREATED,
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
            ref: $ref,
            response: $status,
            description: $description,
            headers: $headers,
            content: $content ?? new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                type: 'object',
                properties: [
                    new OA\Property(
                        type: 'string',
                        property: 'uuid',
                        example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8',
                        uniqueItems: true
                    )
                ]
            )
        ),
            links: $links,
            x: $x,
            attachables: $attachables
        );
    }
}