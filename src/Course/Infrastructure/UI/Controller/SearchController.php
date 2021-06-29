<?php

namespace App\Course\Infrastructure\UI\Controller;

use App\Course\Application\FindCourses\FindCoursesQuery;
use App\Course\Domain\DTO\OrderBy;
use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\Price;
use App\Shared\Domain\Bus\Query\QueryBus;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchController
{
    public function index(Request $request, QueryBus $queryBus, UrlGeneratorInterface $router): JsonResponse
    {
        $orderBy = null;
        try {
            $orderBy = OrderBy::create($request->query->get('orderBy', OrderBy::CATEGORY));
        } catch (\Exception) {
        }
        $searchParams = new SearchParams(
            $request->query->get('category'),
            $request->query->get('level'),
            $request->query->getInt('priceMin'),
            $request->query->getInt('priceMax'),
            $orderBy,
            $request->query->getInt('limit'),
            $request->query->getInt('page'),
        );

        /** @var Paginator $courses */
        $courses = $queryBus->ask(new FindCoursesQuery($searchParams));

        $allParams = $allParamsPrev = $allParamsNext = $request->query->all();

        if (isset($allParamsPrev['page']) && ($allParamsPrev['page'] > $searchParams->page())) {
            $allParamsPrev['page']--;
        }

        if (isset($allParamsNext['page'])) {
            $allParamsNext['page']++;
        } else {
            $allParamsNext['page'] = $searchParams->page() + 1;
        }

        $response = [
            '_links' => [
                'self' => $router->generate('courses', $allParams, UrlGenerator::ABSOLUTE_URL),
                'prev' => $router->generate('courses', $allParamsPrev, UrlGenerator::ABSOLUTE_URL),
                'next' => $router->generate('courses', $allParamsNext, UrlGenerator::ABSOLUTE_URL),
            ],
            'total' => $courses->count(),
            'page' => $searchParams->page(),
            'limit' => $searchParams->limit(),
            'results' => []
        ];

        /** @var Course $course */
        foreach ($courses as $course) {
            $response['results'][] = [
                'title' => $course->code(),
                'description' => $course->description(),
                'categories' => $this->processCategories($course),
                'level' => $course->level()->name(),
                'prices' => $this->processPrices($course),
            ];
        }

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
