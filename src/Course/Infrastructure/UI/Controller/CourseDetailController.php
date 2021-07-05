<?php

namespace App\Course\Infrastructure\UI\Controller;

use App\Course\Application\GetCourse\GetCourseQuery;
use App\Course\Domain\Entity\Course;
use App\Course\Infrastructure\UI\Controller\Util\ProcessCourse;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CourseDetailController
{
    use ProcessCourse;

    public function index(Request $request, QueryBus $queryBus, UrlGeneratorInterface $router): JsonResponse
    {
        $slug = $request->attributes->get('slug');
        /** @var Course $course */
        $course = $queryBus->ask(new GetCourseQuery($slug));

        if (!$course) {
            return new JsonResponse([
                'data' => [],
                'error' => [
                    'message' => 'Course not found'
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        $response = [
            '_links' => [
                'self' => $router->generate('course-detail', ['slug' => $slug], UrlGenerator::ABSOLUTE_URL),
            ],
            'data' => [
                'title' => $course->code(),
                'description' => $course->description(),
                'categories' => $this->processCategories($course),
                'level' => $course->level()->name(),
                'prices' => $this->processPrices($course),
            ]
        ];

        return new JsonResponse($response);
    }
}
