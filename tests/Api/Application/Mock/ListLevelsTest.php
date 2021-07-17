<?php

declare(strict_types=1);

namespace App\Tests\Api\Application\Mock;

use App\Api\Application\ListLevels\ListLevels;
use App\Course\Domain\Entity\CourseLevel;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseLevelRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Lambdish\Phunctional\first;

class ListLevelsTest extends KernelTestCase
{
    public function testValidValues()
    {
        $firstLevelMock = CourseLevel::create('Patata');
        $listLevelsMock = [
            $firstLevelMock,
            CourseLevel::create('Manzana'),
            CourseLevel::create('Pera'),
            CourseLevel::create('Naranja')
        ];

        $courseLevelRepository = $this->createMock(DoctrineCourseLevelRepository::class);

        $courseLevelRepository->expects($this->any())
            ->method('searchAll')
            ->willReturn($listLevelsMock);

        $entityManager = $this->createMock(EntityManager::class);

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($courseLevelRepository);

        $service = new ListLevels(
            $courseLevelRepository
        );

        $listLevels = $service->__invoke();

        /** @var CourseLevel $firstLevel */
        $firstLevel = first($listLevels);

        $this->assertEquals(4, count($listLevels));
        $this->assertEquals('Patata', $firstLevel->name());
    }
}
