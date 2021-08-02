<?php

namespace App\Shared\Application\Transformer\Course;

use App\Course\Domain\Entity\Course;
use App\Shared\Application\Transformer\DataTransformer;

class CourseDetailTransformer implements DataTransformer
{
    private Course $course;
    private CourseCategoryTransformer $courseCategoryTransformer;
    private CoursePricesTransformer $coursePricesTransformer;
    private CourseSectionsTransformer $courseSectionsTransformer;

    public function __construct(
        CourseCategoryTransformer $courseCategoryTransformer,
        CoursePricesTransformer $coursePricesTransformer,
        CourseSectionsTransformer $courseSectionsTransformer
    ) {
        $this->courseCategoryTransformer = $courseCategoryTransformer;
        $this->coursePricesTransformer = $coursePricesTransformer;
        $this->courseSectionsTransformer = $courseSectionsTransformer;
    }

    public function write(mixed $input)
    {
        $this->course = $input;
        $this->courseCategoryTransformer->write($this->course);
        $this->coursePricesTransformer->write($this->course);
        $this->courseSectionsTransformer->write($this->course);
    }

    public function read(): mixed
    {
        return [
            'title' => $this->course->code(),
            'description' => $this->course->description(),
            'categories' => $this->courseCategoryTransformer->read(),
            'level' => $this->course->level()->name(),
            'prices' => $this->coursePricesTransformer->read(),
            'sections' => $this->courseSectionsTransformer->read(),
        ];
    }
}
