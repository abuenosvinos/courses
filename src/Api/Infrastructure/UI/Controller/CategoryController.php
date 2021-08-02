<?php

namespace App\Api\Infrastructure\UI\Controller;

use App\Api\Application\ListCategories\ListCategoriesQuery;
use App\Course\Domain\Entity\CourseCategory;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CategoryController
{
    public function index(QueryBus $queryBus, UrlGeneratorInterface $router): JsonResponse
    {
        $categories = $queryBus->ask(new ListCategoriesQuery());

        $response = [
            '_links' => [
                'self' => $router->generate('api-categories', [], UrlGeneratorInterface::ABSOLUTE_URL)
            ],
            'total' => count($categories),
            'results' => []
        ];

        /** @var CourseCategory $category */
        foreach ($categories as $category) {
            $response['results'][] = [
                'name' => $category->name(),
                'slug' => $category->slug()
            ];
        }

        return new JsonResponse($response);
    }
}
