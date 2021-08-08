<?php

namespace App\Admin\Infrastructure\UI\Controller\User;

use App\Admin\Domain\Repository\UserAdminRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;
use App\Shared\Domain\Criteria\OrderBy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ListController
{
    public function index(Request $request, Environment $twig, UserAdminRepository $userAdminRepository): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 10;

        $criteria = new Criteria(
            new Filters([]),
            Order::createDesc(new OrderBy('id')),
            (($page - 1) * $limit),
            $limit
        );
        $users = $userAdminRepository->search($criteria);

        $path = $request->get('_route');
        $params = $request->query->all();
        unset($params['page']);

        return new Response(
            $twig->render(
                'pages/user/list.html.twig',
                [
                    'users' => $users,
                    'path' => $path,
                    'params' => $params
                ]
            )
        );
    }
}
