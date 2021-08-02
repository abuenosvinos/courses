<?php

namespace App\Shared\Application\Transformer\Course;

use App\Course\Domain\Entity\Course;
use App\Shared\Application\Transformer\DataTransformer;

class CourseListTransformer implements DataTransformer
{
    private Course $course;
    private CourseCategoryTransformer $courseCategoryTransformer;
    private CoursePricesTransformer $coursePricesTransformer;

    public function __construct(CourseCategoryTransformer $courseCategoryTransformer, CoursePricesTransformer $coursePricesTransformer)
    {
        $this->courseCategoryTransformer = $courseCategoryTransformer;
        $this->coursePricesTransformer = $coursePricesTransformer;
    }

    public function write(mixed $input)
    {
        $this->course = $input;
        $this->courseCategoryTransformer->write($this->course);
        $this->coursePricesTransformer->write($this->course);
    }

    public function read(): mixed
    {
        return [
            'title' => $this->course->code(),
            'description' => $this->course->description(),
            'startAt' => $this->course->startAt()->format('Y-m-d H:i:s'),
            'categories' => $this->courseCategoryTransformer->read(),
            'level' => $this->course->level()->name(),
            'prices' => $this->coursePricesTransformer->read(),
        ];
    }
}
