<?php

declare(strict_types=1);

namespace App\Course\Application\FindCourses;

use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Repository\CourseRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class FindCourses
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(SearchParams $searchParams): Paginator
    {
        return $this->courseRepository->findByCriteria($searchParams);
    }
}
