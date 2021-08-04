<?php

namespace App\Admin\Infrastructure\UI\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class SecurityController
{
    public function form(Environment $twig, AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->prepareForm($twig, 'security/login.html.twig', $lastUsername, $error);
//        return $this->prepareForm($twig, 'security/login.html.twig');
    }

    public function login(Environment $twig, AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->prepareForm($twig, 'security/login.html.twig', $lastUsername, $error);
    }

    private function prepareForm(Environment $twig, $template, $username = null, $error = null): Response
    {
        return new Response($twig->render($template, [
            'last_username' => $username,
            'error' => $error
        ]));
    }

    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
