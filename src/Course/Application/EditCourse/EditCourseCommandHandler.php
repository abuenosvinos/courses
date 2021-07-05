<?php

declare(strict_types=1);

namespace App\Course\Application\EditCourse;

use App\Shared\Domain\Bus\Command\CommandHandler;

final class EditCourseCommandHandler implements CommandHandler
{
    private EditCourse $editCourse;

    public function __construct(EditCourse $editCourse)
    {
        $this->editCourse = $editCourse;
    }

    public function __invoke(EditCourseCommand $command): void
    {
        $course = $command->course();

        $this->editCourse->__invoke($course);
    }
}
