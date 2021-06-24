<?php

declare(strict_types=1);

namespace App\Course\Application\AddCourse;

use App\Course\Domain\DTO\Course;
use App\Shared\Domain\Bus\Command\Command;

final class AddCourseCommand extends Command
{
    private Course $course;

    public function __construct(Course $course)
    {
        parent::__construct();

        $this->course = $course;
    }

    public function course(): Course
    {
        return $this->course;
    }
}
