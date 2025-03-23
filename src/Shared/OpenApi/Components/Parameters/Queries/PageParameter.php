<?php

declare(strict_types=1);

namespace Project\Shared\OpenApi\Components\Parameters\Queries;

use OpenApi\Attributes as OA;
use OpenApi\Generator;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;

class PageParameter extends OA\Parameter
{
    public function __construct(
        ?string $parameter = null,
        ?string $name = 'page',
        ?string $description = null,
        ?string $in = 'query',
        ?bool $required = null,
        ?bool $deprecated = null,
        ?bool $allowEmptyValue = null,
        string|object|null $ref = null,
        ?OA\Schema $schema = null,
        ?int $example = Paginator::DEFAULT_PAGE,
        ?array $examples = null,
        array|OA\JsonContent|OA\XmlContent|OA\Attachable|null $content = null,
        ?string $style = null,
        ?bool $explode = null,
        ?bool $allowReserved = null,
        ?array $spaceDelimited = null,
        ?array $pipeDelimited = null,
        // annotation
        ?array $x = null,
        ?array $attachables = null
    ) {
        parent::__construct(
            parameter: $parameter ?? Generator::UNDEFINED,
            name: $name,
            description: $description ?? Generator::UNDEFINED,
            in: $in,
            required: $required,
            deprecated: $deprecated ?? false,
            allowEmptyValue: $allowEmptyValue ?? false,
            ref: $ref ?? Generator::UNDEFINED,
            example: $example,
            style: $style ?? Generator::UNDEFINED,
            explode: $explode ?? false,
            allowReserved: $allowReserved ?? false,
            spaceDelimited: $spaceDelimited ?? [],
            pipeDelimited: $pipeDelimited ?? [],
            x: $x ?? [],
        );
    }
}