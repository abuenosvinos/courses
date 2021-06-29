<?php

declare(strict_types=1);

namespace App\Course\Application\AddCourse;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\CourseId;
use App\Course\Domain\Entity\CourseLevel;
use App\Course\Domain\Entity\Price;
use App\Course\Domain\Repository\CourseCategoryRepository;
use App\Course\Domain\Repository\CourseLevelRepository;
use App\Course\Domain\ValueObject\Currency;
use App\Course\Domain\Event\CourseAdded;
use App\Course\Domain\Repository\CourseRepository;
use App\Course\Domain\DTO\Course as CourseDTO;
use App\Course\Domain\Repository\PricesRepository;
use App\Course\Domain\ValueObject\Money;
use App\Shared\Domain\Bus\Event\EventBus;

final class AddCourse
{
    private CourseRepository $courseRepository;
    private CourseCategoryRepository $courseCategoryRepository;
    private CourseLevelRepository $courseLevelRepository;
    private PricesRepository $pricesRepository;
    private EventBus $bus;

    public function __construct(CourseRepository $courseRepository, CourseCategoryRepository $courseCategoryRepository, CourseLevelRepository $courseLevelRepository, PricesRepository $pricesRepository, EventBus $bus)
    {
        $this->courseRepository = $courseRepository;
        $this->courseCategoryRepository = $courseCategoryRepository;
        $this->courseLevelRepository = $courseLevelRepository;
        $this->pricesRepository = $pricesRepository;
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

        $course = Course::create(
            CourseId::random(),
            $courseDto->code(),
            $courseDto->description(),
            $courseLevel,
            $courseCategory
        );

        $validCodes = $this->pricesRepository->validCodes();
        foreach ($validCodes as $validCode) {
            $course->addPrice(Price::create(
                Money::create(
                    $this->pricesRepository->get(),
                    Currency::create($validCode)
                )
            ));
        }

        $this->courseRepository->save($course);

        $this->bus->notify(...[new CourseAdded(['course' => $course])]);
    }
}
