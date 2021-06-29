<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\CourseId;
use App\Course\Domain\Entity\CourseLevel;
use App\Shared\Domain\ValueObject\Uuid;

final class CourseMother
{
    public static function create(?Uuid $id = null, ?string $code = null, ?string $description = null, ?string $category = null, ?string $level = null): Course
    {
        return Course::create(
            CourseId::create($id ?? UuidMother::random()),
            $code ?? StringMother::random(),
            $description ?? StringMother::random(),
            [CourseCategory::create($category ?? StringMother::random())],
            CourseLevel::create($level ?? StringMother::random())
        );
    }
}
