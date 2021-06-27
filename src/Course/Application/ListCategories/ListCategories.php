<?php

declare(strict_types=1);

namespace App\Course\Application\ListCategories;

use App\Course\Domain\Repository\CourseCategoryRepository;

final class ListCategories
{
    private CourseCategoryRepository $courseCategoryRepository;

    public function __construct(CourseCategoryRepository $courseCategoryRepository)
    {
        $this->courseCategoryRepository = $courseCategoryRepository;
    }

    public function __invoke()
    {
        return $this->courseCategoryRepository->searchAll();
    }
}
