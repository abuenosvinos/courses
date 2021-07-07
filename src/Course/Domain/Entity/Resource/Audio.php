<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity\Resource;

use App\Course\Domain\Entity\Resource;

class Audio extends Resource
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function url(): string
    {
        return $this->url;
    }

    public static function create(string $url): static
    {
        return new static($url);
    }

    public function type(): string
    {
        return 'audio';
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type(),
            'url' => $this->url
        ];
    }
}
