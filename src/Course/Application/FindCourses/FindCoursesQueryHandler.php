<?php

declare(strict_types=1);

namespace App\Course\Application\FindCourses;

use App\Shared\Domain\Bus\Query\QueryHandler;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class FindCoursesQueryHandler implements QueryHandler
{
    private FindCourses $findCourses;

    public function __construct(FindCourses $findCourses)
    {
        $this->findCourses = $findCourses;
    }

    public function __invoke(FindCoursesQuery $query): Paginator
    {
        return $this->findCourses->__invoke($query->searchParams());
    }
}
