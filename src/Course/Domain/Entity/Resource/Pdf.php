<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity\Resource;

use App\Course\Domain\Entity\Resource;

class Pdf extends Resource
{
    private string $path;
    private int $pages;

    public function __construct(string $path, int $pages)
    {
        $this->path = $path;
        $this->pages = $pages;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function pages(): int
    {
        return $this->pages;
    }

    public static function create(string $path, int $pages): static
    {
        return new static($path, $pages);
    }

    public function type(): string
    {
        return 'pdf';
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type(),
            'path' => $this->path,
            'pages' => $this->pages
        ];
    }
}
