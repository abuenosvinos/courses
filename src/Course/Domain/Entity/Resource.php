<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

abstract class Resource
{
    private int $id;
    private CourseChapter $chapter;

    public function chapter(): CourseChapter
    {
        return $this->chapter;
    }

    public function setCourseChapter(CourseChapter $chapter): void
    {
        $this->chapter = $chapter;
    }

    abstract public function type(): string;

    abstract public function toArray(): array;
}
