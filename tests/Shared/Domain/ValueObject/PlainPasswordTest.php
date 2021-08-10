<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\NotValidPasswordException;
use App\Shared\Domain\ValueObject\PlainPassword;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlainPasswordTest extends KernelTestCase
{
    public function testValidValues()
    {
        $password = PlainPassword::create('akr345ERP');

        $this->assertEquals('akr345ERP', $password->value());
    }

    public function testNotValidLength()
    {
        $this->expectException(NotValidPasswordException::class);

        PlainPassword::create('as34RE');
    }

    public function testNotValidUppercase()
    {
        $this->expectException(NotValidPasswordException::class);

        PlainPassword::create('asd894tre934');
    }

    public function testNotValidLowercase()
    {
        $this->expectException(NotValidPasswordException::class);

        PlainPassword::create('ALR943TBM923');
    }
}
