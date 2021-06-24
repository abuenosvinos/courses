<?php

declare(strict_types=1);

namespace App\Course\Application\EditCourse;

use App\Course\Domain\DTO\Course;
use App\Shared\Domain\Bus\Command\Command;

final class EditCourseCommand extends Command
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
