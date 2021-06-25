<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Course extends AggregateRoot
{
    private string $id;
    private string $code;
    private string $slug;
    private string $description;
    private string $category;
    private string $level;
    private \DateTime $created;
    private \DateTime $updated;
    private Collection $prices;

    private function __construct(string $id, string $code, string $description, string $category, string $level)
    {
        $this->id = $id;
        $this->code = $code;
        $this->description = $description;
        $this->category = $category;
        $this->level = $level;
        $this->prices = new ArrayCollection();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function level(): string
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

    public function syncData(string $description, string $category, string $level): void
    {
        $this->description = $description;
        $this->category = $category;
        $this->level = $level;
    }

    public static function create(string $id, string $code, string $description, string $category, string $level)
    {
        return new self($id, $code, $description, $category, $level);
    }
}
