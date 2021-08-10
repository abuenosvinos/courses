<?php

namespace App\Admin\Infrastructure\UI\Controller\User;

use App\Admin\Domain\Entity\Admin;
use App\Shared\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObject\EmailAddress;
use App\Shared\Domain\ValueObject\UserId;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Twig\Environment;

class NewController extends AbstractController
{
    public function form(Request $request, Environment $twig, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createFormBuilder()
            ->add('username', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->getForm();

        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $dataUser = $form->getData();
                $user = Admin::create(UserId::random(), EmailAddress::create($dataUser['username']));
                $user->setPassword($userPasswordHasher->hashPassword($user, $dataUser['password']));
                $user->setRoles(['ROLE_ADMIN']);

                $userRepository->save($user);

                return $this->redirectToRoute('user-list');
            }
        } catch (InvalidArgumentException $exception) {
            $form->get('username')->addError(new FormError($exception->getMessage()));
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
