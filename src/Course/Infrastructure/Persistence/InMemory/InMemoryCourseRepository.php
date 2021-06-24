<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\InMemory;

use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Repository\CourseRepository;
use App\Shared\Domain\ValueObject\Uuid;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class InMemoryCourseRepository implements CourseRepository
{
    private array $courses;

    public function save(Course $course): void
    {
        $this->courses[$course->id()->value()] = $course;
    }

    public function delete(Course $course): void
    {
        unset($this->courses[$course->id()->value()]);
    }

    public function findById(Uuid $id): ?Course
    {
        return $this->courses[$id->value()] ?? null;
    }

    public function findByCode(string $code): ?Course
    {
        foreach ($this->courses as $course) {
            if ($course->code() === $code) {
                return $course;
            }
        }

        return null;
    }

    public function findByCriteria(SearchParams $searchParams): Paginator
    {
        return $this->courses;
    }

    public function searchAll(): array
    {
        return $this->courses;
    }
}
