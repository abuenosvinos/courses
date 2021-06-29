<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Trait\Sluggable;
use App\Shared\Domain\Trait\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Course extends AggregateRoot
{
    use Sluggable;
    use Timestampable;

    private CourseId $id;
    private string $code;
    private string $description;
    private Collection $categories;
    private CourseLevel $level;
    private Collection $prices;

    private function __construct(CourseId $id, string $code, string $description, CourseLevel $level, CourseCategory...$categories)
    {
        $this->id = $id;
        $this->code = $code;
        $this->description = $description;
        $this->prices = new ArrayCollection();
        $this->categories = new ArrayCollection();
        foreach ($categories as $category) {
            $this->categories->add($category);
        }
        $this->level = $level;
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
/*
    public function addCategory(CourseCategory $category): void
    {
        //$category->setCourse($this);
        $this->categories->add($category);
    }
*/
    public function addPrice(Price $price): void
    {
        $price->setCourse($this);
        $this->prices->add($price);
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

    public static function create(CourseId $id, string $code, string $description, CourseLevel $level, CourseCategory...$categories): self
    {
        return new self($id, $code, $description, $level, ...$categories);
    }
}
