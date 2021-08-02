<?php

declare(strict_types=1);

namespace App\Tests\Course\Application;

use App\Course\Application\AddCourse\AddCourse;
use App\Course\Domain\DTO\Course;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseCategoryRepository;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseLevelRepository;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;
use App\Course\Infrastructure\ThirdParty\ThirdPartyPricesRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Tests\Shared\Domain\DatetimeMother;
use App\Tests\Shared\Domain\StringMother;
use App\Tests\Shared\Infrastructure\Persistence\Doctrine\DatabaseCleaner;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\CurlHttpClient;

use function Lambdish\Phunctional\apply;

class AddCourseTest extends KernelTestCase
{
    private EntityManager $entityManager;
    private mixed $pricesUrl;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->pricesUrl = $kernel->getContainer()->getParameter('prices.url');

        apply(new DatabaseCleaner(), [$this->entityManager]);
    }

    public function testValidValues()
    {
        $courseRepository = new DoctrineCourseRepository($this->entityManager);
        $courseCategoryRepository = new DoctrineCourseCategoryRepository($this->entityManager);
        $courseLevelRepository = new DoctrineCourseLevelRepository($this->entityManager);
        $pricesRepository = new ThirdPartyPricesRepository(
            $this->pricesUrl,
            ['EUR','USD'],
            new CurlHttpClient()
        );
        $eventBus = $this->createMock(EventBus::class);

        $service = new AddCourse(
            $courseRepository,
            $courseCategoryRepository,
            $courseLevelRepository,
            $pricesRepository,
            $eventBus
        );

        $courseDto = new Course(
            StringMother::random(),
            StringMother::random(),
            DatetimeMother::random()->format('Y-m-d H:i:s'),
            StringMother::random(),
            StringMother::random()
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
