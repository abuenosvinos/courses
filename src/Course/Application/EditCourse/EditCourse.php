<?php

declare(strict_types=1);

namespace App\Course\Application\EditCourse;

use App\Course\Domain\Entity\CourseLevel;
use App\Course\Domain\Event\CourseModified;
use App\Course\Domain\Repository\CourseLevelRepository;
use App\Course\Domain\Repository\CourseRepository;
use App\Course\Domain\DTO\Course as CourseDTO;
use App\Shared\Domain\Bus\Event\EventBus;

final class EditCourse
{
    private CourseRepository $courseRepository;
    private CourseLevelRepository $courseLevelRepository;
    private EventBus $bus;

    public function __construct(CourseRepository $courseRepository, CourseLevelRepository $courseLevelRepository, EventBus $bus)
    {
        $this->courseRepository = $courseRepository;
        $this->courseLevelRepository = $courseLevelRepository;
        $this->bus        = $bus;
    }

    public function __invoke(CourseDTO $courseDto)
    {
        $courseLevel = $this->courseLevelRepository->findByName($courseDto->level());
        if (!$courseLevel) {
            $courseLevel = CourseLevel::create($courseDto->level());
        }

        $course = $this->courseRepository->findByCode($courseDto->code());
        $course->syncData($courseDto->description(), $courseDto->category(), $courseLevel);

        $this->bus->notify(...[new CourseModified(['course' => $course])]);
    }
}
