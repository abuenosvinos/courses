<?php

namespace App\Course\Infrastructure\UI\Controller\Util;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\Price;

trait ProcessCourse
{
    private function processCategories(Course $course): array
    {
        $categories = [];
        /** @var CourseCategory $category */
        foreach ($course->categories() as $category) {
            $categories[] = [
                'name' => $category->name()
            ];
        }
        return $categories;
    }

    private function processPrices(Course $course): array
    {
        $prices = [];
        /** @var Price $price */
        foreach ($course->prices() as $price) {
            $prices[] = [
                'price' => $price->money()->amount(),
                'code' => $price->money()->currency()->value()
            ];
        }
        return $prices;
    }
}
