<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\NotValidPasswordException;

class PlainPassword extends StringValueObject
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValid($value);

        parent::__construct($value);
    }

    private function ensureIsValid(string $password): void
    {
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);

        if (strlen($password) < 8 || !$number || !$uppercase || !$lowercase) {
            throw new NotValidPasswordException('Password must be at least 8 characters in length and must contain at least one number, one upper case letter and one lower case letter.');
        }
    }

    public function equals(PlainPassword|StringValueObject $other): bool
    {
        return $other->value == $this->value;
    }
}
