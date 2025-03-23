<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Application\Code\Commands\Delete;

use Project\Domains\Admin\Code\Domain\Code\CodeRepositoryInterface;
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