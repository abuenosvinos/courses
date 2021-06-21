<?php

declare(strict_types=1);

namespace App\Course\Domain\DTO;

final class SearchParams
{
    private ?string $category;
    private ?string $level;
    private ?int $priceMin;
    private ?int $priceMax;
    private ?OrderBy $orderBy;
    private ?int $limit;
    private ?int $page;

    public function __construct(?string $category = null, ?string $level = null, ?int $priceMin = null, ?int $priceMax = null, ?OrderBy $orderBy = null, ?int $limit, ?int $page)
    {
        $this->category = $category;
        $this->level = $level;
        $this->priceMin = $priceMin;
        $this->priceMax = $priceMax;
        $this->orderBy = $orderBy;
        $this->limit = $limit;
        $this->page = $page;
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

    public function limit(): ?int
    {
        return (($this->limit && $this->limit > 0) ? $this->limit : 3);
    }

    public function page(): ?int
    {
        return (($this->page && $this->page > 0) ? $this->page : 1);
    }
}
