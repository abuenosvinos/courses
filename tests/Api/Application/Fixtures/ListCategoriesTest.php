<?php

declare(strict_types=1);

namespace App\Tests\Api\Application\Fixtures;

use App\Api\Application\ListCategories\ListCategories;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Infrastructure\Persistence\Doctrine\DataFixtures\CourseFixtures;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseCategoryRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Tests\Shared\Infrastructure\Fixtures\LoadFixtures;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Lambdish\Phunctional\first;

class ListCategoriesTest extends KernelTestCase
{
    use LoadFixtures;

    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();


        $eventBus = $this->createMock(EventBus::class);
        $this->executeFixtures($this->entityManager, new CourseFixtures($eventBus));
    }

    public function testValidValues()
    {
        $courseCategoryRepository = new DoctrineCourseCategoryRepository($this->entityManager);

        $service = new ListCategories(
            $courseCategoryRepository
        );

        $listCategories = $service->__invoke();

        /** @var CourseCategory $firstCategory */
        $firstCategory = first($listCategories);

        $this->assertEquals(3, count($listCategories));
        $this->assertEquals('Categoría 1', $firstCategory->name());
        $this->assertEquals('categoria-1', $firstCategory->slug());
    }
}
