<?php

namespace App\Course\Domain\DTO;

class Courses
{
    private array $courses;

    public function __construct()
    {
        $this->courses = [];
    }

    public function addCourse(Course $course)
    {
        $this->courses[] = $course;
    }

    public function courses(): array
    {
        return $this->courses;
    }
}