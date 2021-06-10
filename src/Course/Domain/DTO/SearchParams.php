<?php

declare(strict_types = 1);

namespace App\Course\Domain\DTO;

final class SearchParams
{
    private ?string $category;
    private ?string $level;
    private ?int $priceMin;
    private ?int $priceMax;
    private ?OrderBy $orderBy;

    public function __construct(?string $category = null, ?string $level = null, ?int $priceMin = null, ?int $priceMax = null, ?OrderBy $orderBy = null)
    {
        $this->category = $category;
        $this->level = $level;
        $this->priceMin = $priceMin;
        $this->priceMax = $priceMax;
        $this->orderBy = $orderBy;
    }

    public function category(): ?string
    {
        return $this->category;
    }

    public function level(): ?string
    {
        return $this->level;
    }

    public function priceMin(): ?int
    {
        return $this->priceMin;
    }

    public function priceMax(): ?int
    {
        return $this->priceMax;
    }

    public function orderBy(): ?OrderBy
    {
        return $this->orderBy;
    }
}