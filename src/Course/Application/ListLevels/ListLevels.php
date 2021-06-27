<?php

declare(strict_types=1);

namespace App\Course\Application\ListLevels;

use App\Course\Domain\Repository\CourseLevelRepository;

final class ListLevels
{
    private CourseLevelRepository $courseLevelRepository;

    public function __construct(CourseLevelRepository $courseLevelRepository)
    {
        $this->courseLevelRepository = $courseLevelRepository;
    }

    public function __invoke()
    {
        return $this->courseLevelRepository->searchAll();
    }
}
