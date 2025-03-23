<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository;

use Project\Shared\Infrastructure\Repository\Contracts\EntityManagerInterface;

class EntityManager extends \Doctrine\ORM\EntityManager implements EntityManagerInterface
{

}