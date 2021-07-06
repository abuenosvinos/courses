<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CourseSection
{
    private int $id;
    private Course $course;
    private string $title;
    private string $description;
    private int $sequence;
    private int $duration;
    private Collection $chapters;

    private function __construct(string $title, string $description, int $sequence)
    {
        $this->title = $title;
        $this->description = $description;
        $this->sequence = $sequence;
        $this->duration = 0;
        $this->chapters = new ArrayCollection();
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function sequence(): int
    {
        return $this->sequence;
    }

    public function duration(): int
    {
        return $this->duration;
    }

    public function addDuration(int $addedDuration): void
    {
        $this->duration += $addedDuration;
    }

    public function chapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(CourseChapter $chapter): void
    {
        $chapter->setSection($this);
        $this->chapters->add($chapter);
    }

    public function setCourse(Course $course): void
    {
        $this->course = $course;
    }

    public static function create(string $title, string $description, int $sequence): CourseSection
    {
        return new self($title, $description, $sequence);
    }
}
