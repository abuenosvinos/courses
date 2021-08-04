<?php

namespace App\Admin\Infrastructure\UI\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController
{
    public function index(Environment $twig): Response
    {
        return new Response(
            $twig->render('pages/home.html.twig')
        );
    }
}
