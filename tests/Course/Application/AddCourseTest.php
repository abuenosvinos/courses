<?php

declare(strict_types=1);

namespace App\Tests\Course\Application;

use App\Course\Application\AddCourse\AddCourse;
use App\Course\Domain\DTO\Course;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;
use App\Course\Infrastructure\ThirdParty\ThirdPartyPricesRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Tests\Shared\Domain\StringMother;
use App\Tests\Shared\Infrastructure\Persistence\Doctrine\DatabaseCleaner;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\CurlHttpClient;

use function Lambdish\Phunctional\apply;

class AddCourseTest extends KernelTestCase
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
        $pricesRepository = new ThirdPartyPricesRepository(
            'http://www.randomnumberapi.com/api/v1.0/random?max=1000&count=1',
            ['EUR','USD'],
            new CurlHttpClient()
        );
        $eventBus = $this->createMock(EventBus::class);

        $service = new AddCourse(
            $courseRepository,
            $pricesRepository,
            $eventBus
        );

        $courseDto = new Course(
            StringMother::random(),
            StringMother::random(),
            StringMother::random(),
            StringMother::random()
        );

        $service->__invoke(
            $courseDto
        );

        $course = $courseRepository->findByCode($courseDto->code());

        $this->assertEquals($course->code(), $courseDto->code());
        $this->assertEquals($course->description(), $courseDto->description());
        $this->assertEquals($course->category(), $courseDto->category());
        $this->assertEquals($course->level(), $courseDto->level());
    }
}
