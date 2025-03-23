<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate;

use Project\Shared\Contracts\ArrayableInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class PaginatorHttpQueryParams implements ArrayableInterface
{
    private function __construct(
        public ?int $page,
        public ?int $perPage,
        public ?string $cursor
    ) { }

    public static function makeFromRequest(SymfonyRequest $request): self
    {
        return new self(
            page: $request->query->getInt('page', 1),
            perPage: $request->query->getInt('per_page', 15),
            cursor: $request->query->get('cursor'),
        );
    }

    public static function makeFromArray(array $data): self
    {
        return new self(
            page: $data['page'] ?? 1,
            perPage: $data['per_page'] ?? 15,
            cursor: $data['cursor'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'per_page' => $this->perPage,
            'cursor' => $this->cursor,
        ];
    }
}
