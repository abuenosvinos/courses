<?php

declare(strict_types=1);

namespace App\Course\Application\AddCourse;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Event\CourseModified;
use App\Course\Domain\Repository\CourseRepository;
use App\Course\Domain\DTO\Course as CourseDTO;
use App\Course\Domain\Repository\PricesRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class AddCourse
{
    private CourseRepository $courseRepository;
    private PricesRepository $pricesRepository;
    private EventBus $bus;

    public function __construct(CourseRepository $courseRepository, PricesRepository $pricesRepository, EventBus $bus)
    {
        $this->courseRepository = $courseRepository;
        $this->pricesRepository = $pricesRepository;
        $this->bus        = $bus;
    }

    public function __invoke(CourseDTO $courseDto)
    {
        $course = Course::create(
            Uuid::random()->value(),
            $courseDto->code(),
            $courseDto->description(),
            $courseDto->category(),
            $courseDto->level(),
            $this->pricesRepository->get()
        );
        $this->courseRepository->save($course);

        $this->bus->notify(...[new CourseModified(['course' => $course])]);
    }
}
