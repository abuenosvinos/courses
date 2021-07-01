<?php

declare(strict_types=1);

namespace App\Tests\Course\Application\Fixtures;

use App\Course\Application\ListLevels\ListLevels;
use App\Course\Domain\Entity\CourseLevel;
use App\Course\Infrastructure\Persistence\Doctrine\DataFixtures\CourseFixtures;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseLevelRepository;
use App\Tests\Shared\Infrastructure\Fixtures\LoadFixtures;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Lambdish\Phunctional\first;

class ListLevelsTest extends KernelTestCase
{
    use LoadFixtures;

    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->executeFixtures($this->entityManager, new CourseFixtures());
    }

    public function testValidValues()
    {
        $courseLevelRepository = new DoctrineCourseLevelRepository($this->entityManager);

        $service = new ListLevels(
            $courseLevelRepository
        );

        $listLevels = $service->__invoke();
        /** @var CourseLevel $firstLevel */
        $firstLevel = first($listLevels);

        $this->assertEquals(3, count($listLevels));
        $this->assertEquals('Nivel 1', $firstLevel->name());
        $this->assertEquals('nivel-1', $firstLevel->slug());
    }
}
