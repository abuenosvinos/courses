<?php

declare(strict_types=1);

namespace App\Course\Domain\Repository;

use App\Course\Domain\Entity\CourseCategory;

interface CourseCategoryRepository
{
    public function findByName(string $name): ?CourseCategory;

    public function searchAll(): array;
}
