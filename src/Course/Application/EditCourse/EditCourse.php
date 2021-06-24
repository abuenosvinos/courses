<?php

declare(strict_types=1);

namespace App\Course\Application\EditCourse;

use App\Course\Domain\Event\CourseModified;
use App\Course\Domain\Repository\CourseRepository;
use App\Course\Domain\DTO\Course as CourseDTO;
use App\Shared\Domain\Bus\Event\EventBus;

final class EditCourse
{
    private CourseRepository $courseRepository;
    private EventBus $bus;

    public function __construct(CourseRepository $courseRepository, EventBus $bus)
    {
        $this->courseRepository = $courseRepository;
        $this->bus        = $bus;
    }

    public function __invoke(CourseDTO $courseDto)
    {
        $course = $this->courseRepository->findByCode($courseDto->code());
        $course->syncData($courseDto->description(), $courseDto->category(), $courseDto->level());

        $this->bus->notify(...[new CourseModified(['course' => $course])]);
    }
}
