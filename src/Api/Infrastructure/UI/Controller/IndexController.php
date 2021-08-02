<?php

namespace App\Api\Infrastructure\UI\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class IndexController
{
    public function index(UrlGeneratorInterface $router): JsonResponse
    {
        return new JsonResponse(
            [
                'user' => $router->generate('api-user', [], UrlGeneratorInterface::ABSOLUTE_URL)
            ]
        );
    }
}
