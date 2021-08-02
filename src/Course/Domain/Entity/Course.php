<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Trait\Sluggable;
use App\Shared\Domain\Trait\Timestampable;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Course extends AggregateRoot
{
    use Sluggable;
    use Timestampable;

    private CourseId $id;
    private string $code;
    private string $description;
    private DateTime $startAt;
    private Collection $categories;
    private CourseLevel $level;
    private Collection $prices;
    private Collection $sections;

    private function __construct(
        CourseId $id,
        string $code,
        string $description,
        DateTime $startAt,
        CourseLevel $level,
        CourseCategory...$categories
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->description = $description;
        $this->startAt = $startAt;
        $this->prices = new ArrayCollection();
        $this->categories = new ArrayCollection();
        foreach ($categories as $category) {
            $this->categories->add($category);
        }
        $this->level = $level;
        $this->sections = new ArrayCollection();
    }

    public function id(): CourseId
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function startAt(): DateTime
    {
        return $this->startAt;
    }

    public function categories(): Collection
    {
        return $this->categories;
    }

    public function level(): CourseLevel
    {
        return $this->level;
    }

    public function prices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): void
    {
        $price->setCourse($this);
        $this->prices->add($price);
    }

    public function sections(): Collection
    {
        return $this->sections;
    }

    public function addSection(CourseSection $section): void
    {
        $section->setCourse($this);
        $this->sections->add($section);
    }

    public function syncData(string $description, CourseLevel $level, CourseCategory...$categories): void
    {
        $this->description = $description;
        $this->level = $level;
        $this->categories->clear();
        foreach ($categories as $category) {
            $this->categories->add($category);
        }
    }

    public static function create(
        CourseId $id,
        string $code,
        string $description,
        DateTime $startAt,
        CourseLevel $level,
        CourseCategory...$categories
    ): self {
        return new self($id, $code, $description, $startAt, $level, ...$categories);
    }
}
