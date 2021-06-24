<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;

final class Course extends AggregateRoot
{
    private string $id;
    private string $code;
    private string $slug;
    private string $description;
    private string $category;
    private string $level;
    private int $price;

    private function __construct(string $id, string $code, string $description, string $category, string $level, int $price)
    {
        $this->id = $id;
        $this->code = $code;
        $this->description = $description;
        $this->category = $category;
        $this->level = $level;
        $this->price = $price;
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

    public function price(): int
    {
        return $this->price;
    }

    public function syncData(string $description, string $category, string $level): void
    {
        $this->description = $description;
        $this->category = $category;
        $this->level = $level;
    }

    public static function create(string $id, string $code, string $description, string $category, string $level, int $price)
    {
        return new self($id, $code, $description, $category, $level, $price);
    }
}
