<?php

declare(strict_types=1);

namespace App\Course\Domain\DTO;

final class Course
{
    private string $code;
    private string $description;
    private string $category;
    private string $level;

    public function __construct(string $code, string $description, string $category, string $level)
    {
        $this->code = $code;
        $this->description = $description;
        $this->category = $category;
        $this->level = $level;
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

    public function level(): string
    {
        return $this->level;
    }
}
