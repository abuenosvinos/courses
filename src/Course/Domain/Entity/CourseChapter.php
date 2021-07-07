<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

class CourseChapter
{
    private int $id;
    private CourseSection $section;
    private string $title;
    private string $description;
    private int $sequence;
    private int $duration;
    private ?Resource $resource;

    private function __construct(string $title, string $description, int $sequence, ?Resource $resource = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->sequence = $sequence;
        $this->duration = 0;
        $this->resource = $resource;
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

    public function setDuration(int $duration): void
    {
        if (isset($this->section)) {
            $this->section->addDuration($duration - $this->duration);
        }
        $this->duration = $duration;
    }

    public function resource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): void
    {
        $resource->setCourseChapter($this);
        $this->resource = $resource;
    }

    public function setSection(CourseSection $section): void
    {
        $this->section = $section;
        $this->section->addDuration($this->duration);
    }

    public static function create(string $title, string $description, int $sequence, ?Resource $resource = null): CourseChapter
    {
        return new self($title, $description, $sequence, $resource);
    }
}
