<?php

namespace App\Api\Infrastructure\UI\Controller;

use App\Api\Application\GetCourse\GetCourseQuery;
use App\Course\Domain\Entity\Course;
use App\Shared\Application\Transformer\Course\CourseDetailTransformer;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CourseDetailController
{
    public function index(
        Request $request,
        QueryBus $queryBus,
        UrlGeneratorInterface $router,
        CourseDetailTransformer $courseDetailTransformer,
    ): JsonResponse {
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

        $courseDetailTransformer->write($course);

        $response = [
            '_links' => [
                'self' => $router->generate('api-course-detail', ['slug' => $slug], UrlGeneratorInterface::ABSOLUTE_URL),
            ],
            'data' =>
                $courseDetailTransformer->read()

        ];

        return new JsonResponse($response);
    }
}
