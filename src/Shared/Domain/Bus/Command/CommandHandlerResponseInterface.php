<?php

namespace Project\Shared\Domain\Bus\Command;

interface CommandHandlerResponseInterface
{
    public function __invoke(CommandInterface $command): array;
}