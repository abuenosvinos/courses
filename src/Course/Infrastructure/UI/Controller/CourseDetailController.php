<?php

namespace App\Course\Infrastructure\UI\Controller;

use App\Course\Application\GetCourse\GetCourseQuery;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\Price;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CourseDetailController
{
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

    private function processCategories(Course $course): array
    {
        $categories = [];
        /** @var CourseCategory $category */
        foreach ($course->categories() as $category) {
            $categories[] = [
                'name' => $category->name()
            ];
        }
        return $categories;
    }

    private function processPrices(Course $course): array
    {
        $prices = [];
        /** @var Price $price */
        foreach ($course->prices() as $price) {
            $prices[] = [
                'price' => $price->money()->amount(),
                'code' => $price->money()->currency()->value()
            ];
        }
        return $prices;
    }
}
