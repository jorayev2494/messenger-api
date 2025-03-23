<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Profile\Commands\Update;

use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\Email;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\FirstName;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\LastName;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\VOs\Uuid;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\ManagerAdapter;
use Project\Infrastructure\Services\Authentication\Auth;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ManagerAdapter $adapter
    ) { }

    public function __invoke(Command $command): void
    {
        $this->adapter->update(
            Uuid::fromValue(Auth::manager()->getUuid()->value),
            Email::fromValue($command->email),
            FirstName::fromValue($command->firstName),
            LastName::fromValue($command->lastName)
        );
    }
}