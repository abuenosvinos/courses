<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use App\Course\Domain\Entity\Course;
use App\Shared\Domain\ValueObject\Uuid;

final class CourseMother
{
    public static function create(?Uuid $id = null, ?string $code = null, ?string $description = null, ?string $category = null, ?string $level = null, ?int $price = null): Course
    {
        return Course::create(
            $id ?? UuidMother::random(),
            $code ?? StringMother::random(),
            $description ?? StringMother::random(),
            $category ?? StringMother::random(),
            $level ?? StringMother::random(),
            $price ?? IntegerMother::random()
        );
    }
}
