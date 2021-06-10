<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\InMemory;

use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Repository\CourseRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class InMemoryCourseRepository implements CourseRepository
{
    private array $courses;

    public function save(Course $course): void
    {
        $this->courses[$course->code()] = $course;
    }

    public function delete(Course $course): void
    {
        unset($this->courses[$course->code()]);
    }

    public function find(string $code): ?Course
    {
        return $this->courses[$code] ?? null;
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
