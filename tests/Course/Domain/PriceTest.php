<?php

declare(strict_types=1);

namespace App\Tests\Course\Domain;

use App\Course\Domain\Entity\Price;
use App\Course\Domain\ValueObject\Currency;
use App\Course\Domain\ValueObject\Money;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PriceTest extends KernelTestCase
{
    private string $pathFile;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->pathFile = $kernel->getContainer()
            ->getParameter('sourceTruth')['path'];
    }

    public function testValidValues()
    {
        $price = Price::create(
            Money::create(
                4,
                Currency::create('EUR')
            )
        );

        $this->assertEquals($price->money()->amount(), 4);
        $this->assertEquals($price->money()->currency()->value(), 'EUR');
    }

    public function testNotValidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        Price::create(
            Money::create(
                -4,
                Currency::create('EUR')
            )
        );
    }

    public function testNotValidCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        Price::create(
            Money::create(
                4,
                Currency::create('EUX')
            )
        );
    }
}
