<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Queries\Index;

use Project\Shared\Domain\Bus\Query\QueryInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class Query implements QueryInterface
{
    private function __construct() {}

    public static function makeFromRequest(Request $request): self
    {
        return new self();
    }
}
