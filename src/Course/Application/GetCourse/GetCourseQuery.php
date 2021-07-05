<?php

declare(strict_types=1);

namespace App\Course\Application\GetCourse;

use App\Shared\Domain\Bus\Query\Query;

final class GetCourseQuery extends Query
{
    private string $slug;

    public function __construct(string $slug)
    {
        parent::__construct();

        $this->slug = $slug;
    }

    public function slug(): string
    {
        return $this->slug;
    }
}
