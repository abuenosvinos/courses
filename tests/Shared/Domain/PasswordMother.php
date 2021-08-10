<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

final class PasswordMother
{
    public static function random(): string
    {
        $password = MotherCreator::random()->password(20);

        if (!preg_match('@[0-9]@', $password)) {
            $password .= MotherCreator::random()->numberBetween(0, 9);
        }

        if (!preg_match('@[A-Z]@', $password)) {
            $password .= chr(rand(65, 90));
        }

        if (!preg_match('@[a-z]@', $password)) {
            $password .= chr(rand(97, 122));
        }

        return $password;
    }
}
