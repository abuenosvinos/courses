<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine;

use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Repository\CourseCategoryRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineCourseCategoryRepository extends DoctrineRepository implements CourseCategoryRepository
{
    public function findByName(string $name): ?CourseCategory
    {
        return $this->repository(CourseCategory::class)->findOneBy(['name' => $name]);
    }

    public function searchAll(): array
    {
        return $this->repository(CourseCategory::class)->findAll();
    }
}
