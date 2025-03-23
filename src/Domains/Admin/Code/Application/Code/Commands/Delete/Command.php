<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Application\Code\Commands\Delete;

use Project\Shared\Domain\Bus\Command\CommandValidate;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends CommandValidate
{
    public function __construct(
        #[Assert\Positive] public readonly int $id
    ) { }
}