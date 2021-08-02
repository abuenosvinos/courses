<?php

declare(strict_types=1);

namespace App\Tests\Course\Application;

use App\Course\Application\EditCourse\EditCourse;
use App\Course\Domain\DTO\Course as CourseDTO;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseCategoryRepository;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseLevelRepository;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Tests\Shared\Domain\CourseMother;
use App\Tests\Shared\Domain\DatetimeMother;
use App\Tests\Shared\Domain\StringMother;
use App\Tests\Shared\Infrastructure\Persistence\Doctrine\DatabaseCleaner;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Lambdish\Phunctional\apply;

class EditCourseTest extends KernelTestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        apply(new DatabaseCleaner(), [$this->entityManager]);
    }

    public function testValidValues()
    {
        $courseRepository = new DoctrineCourseRepository($this->entityManager);
        $courseCategoryRepository = new DoctrineCourseCategoryRepository($this->entityManager);
        $courseLevelRepository = new DoctrineCourseLevelRepository($this->entityManager);
        $eventBus = $this->createMock(EventBus::class);

        $courseToInsert = CourseMother::create();
        $courseRepository->save($courseToInsert);

        $courseDto = new CourseDto(
            $courseToInsert->code(),
            StringMother::random(),
            DatetimeMother::random()->format('Y-m-d H:i:s'),
            StringMother::random(),
            StringMother::random()
        );

        $service = new EditCourse(
            $courseRepository,
            $courseCategoryRepository,
            $courseLevelRepository,
            $eventBus
        );

        $service->__invoke(
            $courseDto
        );

        $course = $courseRepository->findByCode($courseDto->code());

        $this->assertEquals($course->code(), $courseDto->code());
        $this->assertEquals($course->description(), $courseDto->description());
        $this->assertEquals(($course->categories()[0])->name(), $courseDto->category());
        $this->assertEquals($course->level()->name(), $courseDto->level());
    }
}
