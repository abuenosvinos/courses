<?php

declare(strict_types=1);

namespace App\Tests\Course\Infrastructure\ThirdParty;

use App\Course\Infrastructure\ThirdParty\ThirdPartyPricesRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\CurlHttpClient;

class ThirdPartyPricesRepositoryTest extends TestCase
{
    public function testValidValues()
    {
        $pricesRepository = new ThirdPartyPricesRepository(
            'http://www.randomnumberapi.com/api/v1.0/random?max=1000&count=1',
            new CurlHttpClient()
        );
        $price = $pricesRepository->get();

        $this->assertTrue($price >= 0);
        $this->assertTrue($price <= 1000);
    }
}