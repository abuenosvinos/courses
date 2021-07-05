<?php

declare(strict_types=1);

namespace App\Course\Application\DeleteCourse;

use App\Course\Domain\Event\CourseDeleted;
use App\Course\Domain\Repository\CourseRepository;
use App\Shared\Domain\Bus\Event\EventBus;

final class DeleteCourse
{
    private CourseRepository $courseRepository;
    private EventBus $bus;

    public function __construct(CourseRepository $courseRepository, EventBus $bus)
    {
        $this->courseRepository = $courseRepository;
        $this->bus        = $bus;
    }

    public function __invoke(string $code): void
    {
        $course = $this->courseRepository->findByCode($code);

        $this->courseRepository->delete($course);

        $this->bus->notify(...[new CourseDeleted(['course' => $course])]);
    }
}
