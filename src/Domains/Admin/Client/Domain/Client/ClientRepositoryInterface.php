<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Domain\Client;

use Project\Domains\Admin\Client\Domain\Client\ValueObjects\Email;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;

interface ClientRepositoryInterface
{
    public function get(): array;

    public function paginate(): Paginator;

    public function findByUuid(Uuid $uuid): ?Client;

    public function findByEmail(Email $email): ?Client;

    public function save(Client $client): void;

    public function delete(Client $client): void;
}
