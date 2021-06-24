<?php

declare(strict_types=1);

namespace App\Course\Application\DeleteCourse;

use App\Shared\Domain\Bus\Command\CommandHandler;

final class DeleteCourseCommandHandler implements CommandHandler
{
    private DeleteCourse $deleteCourse;

    public function __construct(DeleteCourse $deleteCourse)
    {
        $this->deleteCourse = $deleteCourse;
    }

    public function __invoke(DeleteCourseCommand $command)
    {
        $code = $command->code();

        $this->deleteCourse->__invoke($code);
    }
}
