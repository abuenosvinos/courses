<?php

namespace App\Course\Infrastructure\UI\Controller\Api;

use App\Course\Application\ListLevels\ListLevelsQuery;
use App\Course\Domain\Entity\CourseLevel;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LevelController
{
    public function index(QueryBus $queryBus, UrlGeneratorInterface $router): JsonResponse
    {
        $levels = $queryBus->ask(new ListLevelsQuery());

        $response = [
            '_links' => [
                'self' => $router->generate('api-levels', [], UrlGenerator::ABSOLUTE_URL)
            ],
            'total' => count($levels),
            'results' => []
        ];

        /** @var CourseLevel $level */
        foreach ($levels as $level) {
            $response['results'][] = [
                'name' => $level->name(),
                'slug' => $level->slug()
            ];
        }

        return new JsonResponse($response);
    }
}
