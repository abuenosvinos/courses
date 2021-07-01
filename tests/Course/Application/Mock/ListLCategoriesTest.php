<?php

declare(strict_types=1);

namespace App\Tests\Course\Application\Mock;

use App\Course\Application\ListCategories\ListCategories;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineCourseCategoryRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Lambdish\Phunctional\first;

class ListLCategoriesTest extends KernelTestCase
{
    public function testValidValues()
    {
        $firstCategoryMock = CourseCategory::create('Patata');
        $listCategoriesMock = [
            $firstCategoryMock,
            CourseCategory::create('Manzana'),
            CourseCategory::create('Pera'),
            CourseCategory::create('Naranja')
        ];

        $courseCategoryRepository = $this->createMock(DoctrineCourseCategoryRepository::class);

        $courseCategoryRepository->expects($this->any())
            ->method('searchAll')
            ->willReturn($listCategoriesMock);

        $entityManager = $this->createMock(EntityManager::class);

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($courseCategoryRepository);

        $service = new ListCategories(
            $courseCategoryRepository
        );

        $listCategories = $service->__invoke();

        /** @var CourseCategory $firstCategory */
        $firstCategory = first($listCategories);

        $this->assertEquals(4, count($listCategories));
        $this->assertEquals('Patata', $firstCategory->name());
    }
}
