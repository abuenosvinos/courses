<?php

declare(strict_types=1);

namespace App\Course\Domain\Repository;

use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseId;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface CourseRepository
{
    public function save(Course $course): void;

    public function delete(Course $course): void;

    public function findById(CourseId $id): ?Course;

    public function findByCode(string $code): ?Course;

    public function findByCriteria(SearchParams $searchParams): Paginator;

    public function searchAll(): array;
}
