<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\NotValidEmailAddressException;
use App\Shared\Domain\ValueObject\EmailAddress;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EmailAddressTest extends KernelTestCase
{
    public function testValidValues()
    {
        $email = EmailAddress::create('abuenosvinos@courses.com');

        $this->assertEquals('abuenosvinos@courses.com', $email->value());
    }

    public function testNotValidValue()
    {
        $this->expectException(NotValidEmailAddressException::class);

        EmailAddress::create('patata');
    }
}
