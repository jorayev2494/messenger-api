<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Translation\Entity\Traits;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait HasTranslate
{
    #[ORM\JoinTable(name: 'translations')]
    #[ORM\JoinColumn(name: 'translation_uuid', referencedColumnName: 'uuid')]
    #[ORM\InverseJoinColumn(name: '')]
    #[ORM\OneToMany()]
    private Collection $translations;
}