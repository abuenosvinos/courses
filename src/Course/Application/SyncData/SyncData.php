<?php

declare(strict_types=1);

namespace App\Course\Application\SyncData;

use App\Course\Application\AddCourse\AddCourseCommand;
use App\Course\Application\DeleteCourse\DeleteCourseCommand;
use App\Course\Application\EditCourse\EditCourseCommand;
use App\Course\Domain\DTO\Course as CourseDTO;
use App\Course\Domain\DTO\Courses;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Repository\CourseRepository;
use App\Shared\Domain\Bus\Command\CommandBus;

final class SyncData
{
    private CourseRepository $courseRepository;
    private CommandBus $bus;

    public function __construct(CourseRepository $courseRepository, CommandBus $bus)
    {
        $this->courseRepository = $courseRepository;
        $this->bus        = $bus;
    }

    public function __invoke(Courses $courses): void
    {
        $coursesDatabase = $this->courseRepository->searchAll();

        /** @var Course $coursesDatabase */
        foreach ($coursesDatabase as $courseDatabase) {
            $find = false;

            /** @var CourseDTO $course */
            foreach ($courses->courses() as $course) {
                if ($courseDatabase->code() === $course->code()) {
                    $find = true;
                    break;
                }
            }

            if (!$find) {
                $this->bus->dispatch(new DeleteCourseCommand($courseDatabase->code()));
            }
        }

        /** @var CourseDTO $course */
        foreach ($courses->courses() as $course) {
            $courseDatabase = $this->courseRepository->findByCode($course->code());
            if (isset($courseDatabase)) {
                $this->bus->dispatch(new EditCourseCommand(new CourseDTO(
                    $course->code(),
                    $course->description(),
                    $course->startAt(),
                    $course->category(),
                    $course->level()
                )));
            } else {
                $this->bus->dispatch(new AddCourseCommand(new CourseDTO(
                    $course->code(),
                    $course->description(),
                    $course->startAt(),
                    $course->category(),
                    $course->level()
                )));
            }
        }
    }
}
