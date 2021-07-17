<?php

declare(strict_types=1);

namespace App\Api\Application\GetCourse;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Repository\CourseRepository;

final class GetCourse
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(string $slug): ?Course
    {
        return $this->courseRepository->findBySlug($slug);
    }
}
