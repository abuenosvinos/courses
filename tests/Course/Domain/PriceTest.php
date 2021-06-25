<?php

declare(strict_types=1);

namespace App\Tests\Course\Domain;

use App\Course\Domain\Entity\Price;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Lambdish\Phunctional\first;

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
        $price = Price::create(4, 'EUR');

        $this->assertEquals($price->value(), 4);
        $this->assertEquals($price->code(), 'EUR');
    }

    public function testNotValidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        Price::create(-4, 'EUR');
    }

    public function testNotValidCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        Price::create(4, 'EUS');
    }
}
