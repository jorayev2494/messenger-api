<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Member\Queries\GetRole;

use Project\Shared\Domain\Bus\Query\QueryInterface;

readonly class Query implements QueryInterface
{
    public function __construct(
        public string $memberUuid
    ) { }
}