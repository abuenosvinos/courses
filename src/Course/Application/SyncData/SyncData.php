<?php

declare(strict_types=1);

namespace App\Course\Application\SyncData;

use App\Course\Domain\DTO\Course as CourseDTO;
use App\Course\Domain\DTO\Courses;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Event\CourseAdded;
use App\Course\Domain\Event\CourseDeleted;
use App\Course\Domain\Event\CourseModified;
use App\Course\Domain\Repository\CourseRepository;
use App\Course\Domain\Repository\PricesRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class SyncData
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

    public function __invoke(Courses $courses)
    {
        $coursesDatabase = $this->courseRepository->searchAll();
        /** @var Course $coursesDatabase */
        foreach ($coursesDatabase as $courseDatabase) {
            $find = false;

            /** @var CourseDTO $course */
            foreach ($courses as $course) {
                if ($courseDatabase->code() === $course->code()) {
                    $find = true;
                    break;
                }
            }

            if (!$find) {
                $this->courseRepository->delete($courseDatabase);

                $this->bus->notify(...[new CourseDeleted(['course' => $courseDatabase])]);
            }
        }

        /** @var CourseDTO $course */
        foreach ($courses->courses() as $course) {
            $courseDatabase = $this->courseRepository->find($course->code());
            if (isset($courseDatabase)) {
                $courseDatabase->syncData($course->description(), $course->category(), $course->level());

                $this->bus->notify(...[new CourseAdded(['course' => $courseDatabase])]);
            } else {
                $courseDatabase = Course::create(
                    Uuid::random(),
                    $course->code(),
                    $course->description(),
                    $course->category(),
                    $course->level(),
                    $this->pricesRepository->get()
                );

                $this->bus->notify(...[new CourseModified(['course' => $courseDatabase])]);
            }
            $this->courseRepository->save($courseDatabase);
        }
    }
}
