<?php

namespace App\Api\Infrastructure\UI\Controller\Util;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\CourseChapter;
use App\Course\Domain\Entity\CourseSection;
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

    private function processSections(Course $course): array
    {
        $sections = [];
        /** @var CourseSection $section */
        foreach ($course->sections() as $section) {
            $sections[] = [
                'title' => $section->title(),
                'description' => $section->description(),
                'duration' => $section->duration(),
                'chapters' => $this->processChapters($section)
            ];
        }
        return $sections;
    }

    private function processChapters(CourseSection $courseSection): array
    {
        $sections = [];
        /** @var CourseChapter $chapter */
        foreach ($courseSection->chapters() as $chapter) {
            $dataChapter = [
                'title' => $chapter->title(),
                'description' => $chapter->description(),
                'duration' => $chapter->duration()
            ];
            $resource = $chapter->resource();
            if ($resource) {
                $dataChapter['resource'] = $resource->toArray();
            }
            $sections[] = $dataChapter;
        }
        return $sections;
    }
}
