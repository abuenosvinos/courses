<?php

declare(strict_types=1);

namespace App\Tests\Course\Infrastructure\Persistence\Doctrine;

use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;
use App\Tests\Shared\Domain\CourseMother;
use App\Tests\Shared\Infrastructure\Persistence\Doctrine\DatabaseCleaner;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Lambdish\Phunctional\apply;

class DoctrineCourseRepositoryTest extends KernelTestCase
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

        $courseA = CourseMother::create();
        $courseRepository->save($courseA);
        $courseB = CourseMother::create();
        $courseRepository->save($courseB);

        $this->assertEquals(count($courseRepository->searchAll()), 2);
        $this->assertEquals($courseRepository->find($courseB->code()), $courseB);

        $courseRepository->delete($courseA);

        $this->assertEquals(count($courseRepository->searchAll()), 1);
        $this->assertEquals($courseRepository->find($courseA->code()), null);
    }
}
