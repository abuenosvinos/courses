<?php

declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Fixtures;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

trait LoadFixtures
{
    public function executeFixtures(EntityManagerInterface $entityManager, FixtureInterface...$fixture)
    {
        $ormExecutor = new ORMExecutor($entityManager, new ORMPurger($entityManager));
        $ormExecutor->execute($fixture);
    }
}