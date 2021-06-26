<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

use App\Course\Domain\ValueObject\Money;

class Price
{
    public const EUR = 'EUR';
    public const USD = 'USD';

    private int $id;
    private Course $course;
    private Money $money;

    private function __construct(Money $money)
    {
        $this->money = $money;
    }

    public function money(): Money
    {
        return $this->money;
    }

    public function setCourse(Course $course): void
    {
        $this->course = $course;
    }

    public static function create(Money $money): Price
    {
        return new self($money);
    }
}
