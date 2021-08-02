<?php

namespace App\Shared\Application\Transformer\Course;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseCategory;
use App\Shared\Application\Transformer\DataTransformer;

class CourseCategoryTransformer implements DataTransformer
{
    private Course $course;

    public function write(mixed $input)
    {
        $this->course = $input;
    }

    public function read(): mixed
    {
        $categories = [];
        /** @var CourseCategory $category */
        foreach ($this->course->categories() as $category) {
            $categories[] = [
                'name' => $category->name()
            ];
        }
        return $categories;
    }
}
