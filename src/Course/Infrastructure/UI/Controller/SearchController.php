<?php

namespace App\Course\Infrastructure\UI\Controller;

use App\Course\Application\FindCourses\FindCoursesQuery;
use App\Course\Domain\DTO\OrderBy;
use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Entity\Course;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchController
{
    public function index(Request $request, QueryBus $queryBus): JsonResponse
    {
        $orderBy = null;
        try {
            $orderBy = new OrderBy($request->query->get('orderBy', OrderBy::CATEGORY));
        } catch (\Exception $e) {
        }
        $searchParams = new SearchParams(
            $request->query->get('category'),
            $request->query->get('level'),
            $request->query->getInt('priceMin'),
            $request->query->getInt('priceMax'),
            $orderBy,
        );
        $courses = $queryBus->ask(new FindCoursesQuery($searchParams));

        $response = [];
        /** @var Course $course */
        foreach ($courses as $course) {
            $response[] = [
                'title' => $course->code(),
                'description' => $course->description(),
                'category' => $course->category(),
                'level' => $course->level(),
                'price' => $course->price(),
            ];
        }

        return new JsonResponse($response);
    }
}
