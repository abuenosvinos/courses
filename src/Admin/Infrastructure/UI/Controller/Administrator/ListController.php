<?php

namespace App\Admin\Infrastructure\UI\Controller\Administrator;

use App\Admin\Domain\Repository\UserAdminRepository;
use App\Admin\Infrastructure\UI\Form\Filter\Admin\AdminFilter;
use App\Admin\Infrastructure\UI\Form\Filter\Admin\AdminFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ListController extends AbstractController
{
    public function list(Request $request, Environment $twig, UserAdminRepository $userAdminRepository): Response
    {
        $adminFilter = new AdminFilter($request);
        $filterForm = $this->createForm(AdminFilterType::class, null, ['method' => 'GET', 'csrf_protection' => false]);

        $users = $userAdminRepository->search(
            $adminFilter->getCriteria($filterForm)
        );

        return new Response(
            $twig->render(
                'pages/administrator/list.html.twig',
                [
                    'filterForm' => $filterForm->createView(),
                    'users' => $users,
                    'path' => $adminFilter->getPath(),
                    'params' => $adminFilter->getParams()
                ]
            )
        );
    }
}
