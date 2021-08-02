<?php

namespace App\Shared\Application\Transformer\Course;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseSection;
use App\Shared\Application\Transformer\DataTransformer;

class CourseSectionsTransformer implements DataTransformer
{
    private Course $course;
    private CourseChaptersTransformer $courseChaptersTransformer;

    public function __construct(CourseChaptersTransformer $courseChaptersTransformer)
    {
        $this->courseChaptersTransformer = $courseChaptersTransformer;
    }

    public function write(mixed $input)
    {
        $this->course = $input;
    }

    public function read(): mixed
    {
        $sections = [];
        /** @var CourseSection $section */
        foreach ($this->course->sections() as $section) {
            $this->courseChaptersTransformer->write($section);
            $sections[] = [
                'title' => $section->title(),
                'description' => $section->description(),
                'duration' => $section->duration(),
                'chapters' => $this->courseChaptersTransformer->read()
            ];
        }
        return $sections;
    }
}
