<?php

declare(strict_types=1);

namespace App\Shared\Domain\Trait;

trait Timestampable
{
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
