<?php

declare(strict_types=1);

namespace App\Tests\Course\Application;

use App\Course\Application\DeleteCourse\DeleteCourse;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Tests\Shared\Domain\CourseMother;
use App\Tests\Shared\Infrastructure\Persistence\Doctrine\DatabaseCleaner;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Lambdish\Phunctional\apply;

class DeleteCourseTest extends KernelTestCase
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
        $eventBus = $this->createMock(EventBus::class);

        $courseToInsert = CourseMother::create();
        $courseRepository->save($courseToInsert);

        $courseRecoveredA = $courseRepository->findByCode($courseToInsert->code());
        $this->assertEquals($courseRecoveredA->description(), $courseToInsert->description());

        $service = new DeleteCourse(
            $courseRepository,
            $eventBus
        );

        $service->__invoke(
            $courseToInsert->code()
        );

        $courseRecoveredB = $courseRepository->findByCode($courseToInsert->code());
        $this->assertEquals($courseRecoveredB, null);
    }
}
