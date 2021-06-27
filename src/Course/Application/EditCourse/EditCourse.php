<?php

declare(strict_types=1);

namespace App\Course\Application\EditCourse;

use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\CourseLevel;
use App\Course\Domain\Event\CourseModified;
use App\Course\Domain\Repository\CourseCategoryRepository;
use App\Course\Domain\Repository\CourseLevelRepository;
use App\Course\Domain\Repository\CourseRepository;
use App\Course\Domain\DTO\Course as CourseDTO;
use App\Shared\Domain\Bus\Event\EventBus;

final class EditCourse
{
    private CourseRepository $courseRepository;
    private CourseCategoryRepository $courseCategoryRepository;
    private CourseLevelRepository $courseLevelRepository;
    private EventBus $bus;

    public function __construct(CourseRepository $courseRepository, CourseCategoryRepository $courseCategoryRepository, CourseLevelRepository $courseLevelRepository, EventBus $bus)
    {
        $this->courseRepository = $courseRepository;
        $this->courseCategoryRepository = $courseCategoryRepository;
        $this->courseLevelRepository = $courseLevelRepository;
        $this->bus        = $bus;
    }

    public function __invoke(CourseDTO $courseDto)
    {
        $courseCategory = $this->courseCategoryRepository->findByName($courseDto->category());
        if (!$courseCategory) {
            $courseCategory = CourseCategory::create($courseDto->category());
        }

        $courseLevel = $this->courseLevelRepository->findByName($courseDto->level());
        if (!$courseLevel) {
            $courseLevel = CourseLevel::create($courseDto->level());
        }

        $course = $this->courseRepository->findByCode($courseDto->code());
        $course->syncData($courseDto->description(), [$courseCategory], $courseLevel);

        $this->bus->notify(...[new CourseModified(['course' => $course])]);
    }
}
