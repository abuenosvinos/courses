<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\ThirdParty;

use App\Course\Domain\Repository\PricesRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ThirdPartyPricesRepository implements PricesRepository
{
    private string $urlServicePrices;
    private HttpClientInterface $httpClient;

    public function __construct(string $urlServicePrices, HttpClientInterface $httpClient)
    {
        $this->urlServicePrices = $urlServicePrices;
        $this->httpClient = $httpClient;
    }

    public function get(): int
    {
        $response = $this->httpClient->request(
            'GET',
            $this->urlServicePrices
        );

        $content = $response->getContent();
        $content = str_replace(['[',']'], '', $content);

        return intval($content);
    }
}