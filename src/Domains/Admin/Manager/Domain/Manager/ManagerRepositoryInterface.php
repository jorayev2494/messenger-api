<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager;

use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;

interface ManagerRepositoryInterface
{
    public function get(): array;

    public function paginate(): Paginator;

    public function findByUuid(Uuid $uuid): ?Manager;

    public function findByEmail(Email $email): ?Manager;

    public function save(Manager $manager): void;

    public function delete(Manager $manager): void;
}
