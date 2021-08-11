<?php

namespace App\Admin\Infrastructure\UI\Controller\Administrator;

use App\Shared\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DeleteController
{
    public function delete(Request $request, Environment $twig, UserRepository $userRepository): Response
    {
        $id = $request->query->get('id');
        $user = $userRepository->findById(UserId::create($id));
        if ($user) {
            $userRepository->remove($user);
        }

        return new Response(
            $twig->render(
                'pages/administrator/list.html.twig',
                [
                ]
            )
        );
    }
}
