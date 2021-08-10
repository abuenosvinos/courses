<?php

namespace App\Admin\Infrastructure\UI\Controller\User;

use App\Admin\Domain\Entity\Admin;
use App\Admin\Infrastructure\UI\Form\DataTransformer\PasswordDataTransformer;
use App\Admin\Infrastructure\UI\Form\DataTransformer\PlainPasswordDataTransformer;
use App\Shared\Domain\Exception\NotValidPasswordException;
use App\Shared\Domain\Repository\PasswordRepository;
use App\Shared\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class EditPasswordController extends AbstractController
{
    public function form(
        Request $request,
        Environment $twig,
        UserRepository $userRepository,
        PasswordRepository $passwordRepository,
        PasswordDataTransformer $passwordDataTransformer,
        PlainPasswordDataTransformer $plainPasswordDataTransformer
    ): Response {
        $id = $request->attributes->get('id');
        $user = $userRepository->findById(UserId::create($id));

        $formBuilder = $this->createFormBuilder($user)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ]);

        $formBuilder->get('password')->addModelTransformer($passwordDataTransformer);
        $formBuilder->get('password')->get('first')->addModelTransformer($plainPasswordDataTransformer);
        $formBuilder->get('password')->get('second')->addModelTransformer($plainPasswordDataTransformer);

        $form = $formBuilder->getForm();

        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var Admin $user */
                $user = $form->getData();
                $user->setPassword($passwordRepository->create($user, $user->password()->value()));

                $userRepository->save($user);

                return $this->redirectToRoute('user-list');
            }
        } catch (NotValidPasswordException $exception) {
            $form->get('password')->get('first')->addError(new FormError($exception->getMessage()));
        }

        return new Response(
            $twig->render(
                'pages/user/edit-password.html.twig',
                [
                    'form' => $form->createView()
                ]
            )
        );
    }
}
