<?php

namespace App\Api\Infrastructure\UI\Controller;

use App\Api\Application\FindCourses\FindCoursesQuery;
use App\Course\Domain\DTO\OrderBy;
use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Entity\Course;
use App\Shared\Application\Paginator;
use App\Shared\Application\Transformer\Course\CourseListTransformer;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchController
{
    public function index(Request $request, QueryBus $queryBus, UrlGeneratorInterface $router, CourseListTransformer $courseListTransformer): JsonResponse
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
                'self' => $router->generate('api-courses', $allParams, UrlGeneratorInterface::ABSOLUTE_URL),
                'prev' => $router->generate('api-courses', $allParamsPrev, UrlGeneratorInterface::ABSOLUTE_URL),
                'next' => $router->generate('api-courses', $allParamsNext, UrlGeneratorInterface::ABSOLUTE_URL),
            ],
            'total' => $courses->count(),
            'page' => $searchParams->page(),
            'limit' => $searchParams->limit(),
            'results' => []
        ];

        /** @var Course $course */
        foreach ($courses as $course) {
            $courseListTransformer->write($course);

            $response['results'][] = array_merge(
                [
                    '_links' => [
                        'self' => $router->generate('api-course-detail', ['slug' => $course->slug()], UrlGeneratorInterface::ABSOLUTE_URL)
                    ]
                ],
                $courseListTransformer->read()
            );
        }

        return new JsonResponse($response);
    }
}
