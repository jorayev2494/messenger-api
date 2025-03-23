<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Application\Code\Commands\Delete;

use Project\Domains\Client\Code\Domain\Code\CodeRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CodeRepositoryInterface $repository
    ) { }

    public function __invoke(Command $command): void
    {
        $code = $this->repository->findById($command->id);

        if ($code === null) {
            return;
        }

        $this->repository->delete($code);
    }
}