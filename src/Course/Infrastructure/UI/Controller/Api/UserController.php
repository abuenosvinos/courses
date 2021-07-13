<?php

namespace App\Course\Infrastructure\UI\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class UserController
{
    public function index(Security $security): JsonResponse
    {
        $user = $security->getUser();

        return new JsonResponse(
            [
                'username' => $user->getUserIdentifier()
            ]
        );
    }
}
