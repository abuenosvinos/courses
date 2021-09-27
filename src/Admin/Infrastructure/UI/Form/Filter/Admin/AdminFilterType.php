<?php

namespace App\Admin\Infrastructure\UI\Form\Filter\Admin;

use App\Admin\Infrastructure\UI\Form\Filter\BaseFilterType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminFilterType extends BaseFilterType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username_value', TextType::class, ['label' => 'Username'])
            ->add('filter', SubmitType::class)
        ;
    }
}
