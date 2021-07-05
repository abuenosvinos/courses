<?php

declare(strict_types=1);

namespace App\Course\Application\GetCourse;

use App\Course\Domain\Entity\Course;
use App\Shared\Domain\Bus\Query\QueryHandler;

final class GetCourseQueryHandler implements QueryHandler
{
    private GetCourse $getCourse;

    public function __construct(GetCourse $getCourse)
    {
        $this->getCourse = $getCourse;
    }

    public function __invoke(GetCourseQuery $query): ?Course
    {
        return $this->getCourse->__invoke($query->slug());
    }
}
