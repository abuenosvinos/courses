<?php

namespace App\Admin\Infrastructure\UI\Controller\User;

use App\Admin\Domain\Entity\Admin;
use App\Shared\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Twig\Environment;

class NewController extends AbstractController
{
    public function form(Request $request, Environment $twig, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createFormBuilder(Admin::create(UserId::random(), ''))
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Admin $user */
            $user = $form->getData();
            $user->setPassword($userPasswordHasher->hashPassword($user, $user->password()));
            $user->setRoles(['ROLE_ADMIN']);

            $userRepository->save($user);

            return $this->redirectToRoute('user-list');
        }

        return new Response(
            $twig->render(
                'pages/user/new.html.twig',
                [
                    'form' => $form->createView()
                ]
            )
        );
    }
}
