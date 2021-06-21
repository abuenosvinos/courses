<?php

declare(strict_types=1);

namespace App\Course\Application\SyncData;

use App\Course\Domain\DTO\Course as CourseDTO;
use App\Course\Domain\DTO\Courses;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Repository\CourseRepository;
use App\Course\Domain\Repository\PricesRepository;

final class SyncData
{
    private CourseRepository $courseRepository;
    private PricesRepository $pricesRepository;

    public function __construct(CourseRepository $courseRepository, PricesRepository $pricesRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->pricesRepository = $pricesRepository;
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
            }
        }

        /** @var CourseDTO $course */
        foreach ($courses->courses() as $course) {
            $courseDatabase = $this->courseRepository->find($course->code());
            if (isset($courseDatabase)) {
                $courseDatabase->syncData($course->description(), $course->category(), $course->level());
            } else {
                $courseDatabase = Course::create(
                    $course->code(),
                    $course->description(),
                    $course->category(),
                    $course->level(),
                    $this->pricesRepository->get()
                );
            }
            $this->courseRepository->save($courseDatabase);
        }
    }
}
