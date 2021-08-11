<?php

namespace App\Admin\Infrastructure\UI\Controller\Administrator;

use App\Admin\Domain\Entity\Admin;
use App\Shared\Domain\Exception\NotValidEmailAddressException;
use App\Shared\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class EditController extends AbstractController
{
    public function form(Request $request, Environment $twig, UserRepository $userRepository): Response
    {
        $id = $request->attributes->get('id');
        $user = $userRepository->findById(UserId::create($id));

        $form = $this->createFormBuilder($user)
            ->add('username', EmailType::class)
            ->getForm();

        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var Admin $user */
                $user = $form->getData();

                $userRepository->save($user);

                return $this->redirectToRoute('administrator-list');
            }
        } catch (NotValidEmailAddressException $exception) {
            $form->get('username')->addError(new FormError($exception->getMessage()));
        }

        return new Response(
            $twig->render(
                'pages/administrator/edit.html.twig',
                [
                    'form' => $form->createView()
                ]
            )
        );
    }
}
