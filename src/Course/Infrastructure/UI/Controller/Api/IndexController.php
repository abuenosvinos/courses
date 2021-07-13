<?php

namespace App\Course\Infrastructure\UI\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class IndexController
{
    public function index(UrlGeneratorInterface $router): JsonResponse
    {
        return new JsonResponse(
            [
                'user' => $router->generate('api-user', [], UrlGenerator::ABSOLUTE_URL)
            ]
        );
    }
}
