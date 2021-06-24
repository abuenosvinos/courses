<?php

declare(strict_types=1);

namespace App\Course\Application\AddCourse;

use App\Shared\Domain\Bus\Command\CommandHandler;

final class AddCourseCommandHandler implements CommandHandler
{
    private AddCourse $addCourse;

    public function __construct(AddCourse $addCourse)
    {
        $this->addCourse = $addCourse;
    }

    public function __invoke(AddCourseCommand $command)
    {
        $course = $command->course();

        $this->addCourse->__invoke($course);
    }
}
