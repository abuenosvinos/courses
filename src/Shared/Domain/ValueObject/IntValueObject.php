<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    protected function __construct(protected int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isBiggerThan(IntValueObject $other): bool
    {
        return $this->value() > $other->value();
    }

    public function __toString()
    {
        return $this->value();
    }

    public static function create(int $value): static
    {
        return new static($value);
    }
}
