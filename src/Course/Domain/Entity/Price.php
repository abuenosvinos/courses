<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

use InvalidArgumentException;

class Price
{
    public const EUR = 'EUR';
    public const USD = 'USD';

    private int $id;
    private Course $course;
    private int $value;
    private string $code;

    private function __construct(int $value, string $code)
    {
        $this->validate($value, $code);

        $this->value = $value;
        $this->code = $code;
    }

    private function validate(int $value, string $code)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Price can\'t be negative');
        }

        if ($code !== self::EUR && $code !== self::USD) {
            throw new InvalidArgumentException(sprintf('It\'s not a valid code for a Price (%s)', $code));
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function setCourse(Course $course): void
    {
        $this->course = $course;
    }

    public static function create(int $value, string $code): Price
    {
        return new self($value, $code);
    }
}
