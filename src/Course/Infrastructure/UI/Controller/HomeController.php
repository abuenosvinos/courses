<?php

namespace App\Course\Infrastructure\UI\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HomeController
{
    public function index(UrlGeneratorInterface $router): JsonResponse
    {
        return new JsonResponse(
            []
        );
    }
}
