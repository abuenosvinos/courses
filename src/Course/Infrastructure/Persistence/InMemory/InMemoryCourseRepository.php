<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\InMemory;

use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseId;
use App\Course\Domain\Repository\CourseRepository;
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

    public function findById(CourseId $id): ?Course
    {
        return $this->courses[$id->value()] ?? null;
    }

    public function findBySlug(string $slug): ?Course
    {
        /** @var Course $course */
        foreach ($this->courses as $course) {
            if ($course->slug() === $slug) {
                return $course;
            }
        }

        return null;
    }

    public function findByCode(string $code): ?Course
    {
        /** @var Course $course */
        foreach ($this->courses as $course) {
            if ($course->code() === $code) {
                return $course;
            }
        }

        return null;
    }

    public function findByCriteria(SearchParams $searchParams): Paginator
    {
        return new Paginator(null);
    }

    public function searchAll(): array
    {
        return $this->courses;
    }
}
