<?php

namespace Project\Infrastructure\Services\Translation\Entity\Contracts;

use Doctrine\Common\Collections\Collection;

interface TranslatableInterface
{
    public function getTranslations(): Collection;
}