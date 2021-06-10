<?php

declare(strict_types = 1);

namespace App\Course\Application\FindCourses;

use App\Course\Domain\DTO\SearchParams;
use App\Shared\Domain\Bus\Query\Query;

final class FindCoursesQuery extends Query
{
    private SearchParams $searchParams;

    public function __construct(SearchParams $searchParams)
    {
        parent::__construct();

        $this->searchParams = $searchParams;
    }

    public function searchParams(): SearchParams
    {
        return $this->searchParams;
    }
}
