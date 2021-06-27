<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

use App\Shared\Domain\Trait\Sluggable;

final class CourseLevel
{
    use Sluggable;

    private int $id;
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public static function create(string $name): self
    {
        return new self($name);
    }
}
