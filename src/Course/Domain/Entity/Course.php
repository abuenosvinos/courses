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
    private string $category;
    private CourseLevel $level;
    private Collection $prices;

    private function __construct(CourseId $id, string $code, string $description, string $category, CourseLevel $level)
    {
        $this->id = $id;
        $this->code = $code;
        $this->description = $description;
        $this->category = $category;
        $this->level = $level;
        $this->prices = new ArrayCollection();
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

    public function category(): string
    {
        return $this->category;
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

    public function syncData(string $description, string $category, CourseLevel $level): void
    {
        $this->description = $description;
        $this->category = $category;
        $this->level = $level;
    }

    public static function create(CourseId $id, string $code, string $description, string $category, CourseLevel $level): self
    {
        return new self($id, $code, $description, $category, $level);
    }
}
