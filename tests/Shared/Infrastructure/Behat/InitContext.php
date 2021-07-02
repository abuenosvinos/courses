<?php

declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Behat;

use App\Course\Infrastructure\Persistence\Doctrine\DataFixtures\CourseFixtures;
use App\Course\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use App\Tests\Shared\Infrastructure\Fixtures\LoadFixtures;
use Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\ORM\EntityManagerInterface;

class InitContext extends RawMinkContext
{
    use LoadFixtures;

    private EntityManagerInterface $entityManager;
    private CourseFixtures $courseFixtures;
    private UserFixtures $userFixtures;

    public function __construct(EntityManagerInterface $entityManager, CourseFixtures $courseFixtures, UserFixtures $userFixtures)
    {
        $this->entityManager = $entityManager;
        $this->courseFixtures = $courseFixtures;
        $this->userFixtures = $userFixtures;
    }

    /**
     * @Given /^the data of the fixtures is loaded$/
     */
    public function theDataOfTheFixturesIsLoaded()
    {
        $this->executeFixtures($this->entityManager, $this->courseFixtures, $this->userFixtures);
    }
}
