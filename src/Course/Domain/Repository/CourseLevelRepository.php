<?php

declare(strict_types=1);

namespace App\Course\Domain\Repository;

use App\Course\Domain\Entity\CourseLevel;

interface CourseLevelRepository
{
    public function findByName(string $name): ?CourseLevel;

    public function searchAll(): array;
}
