<?php

namespace App\Admin\Infrastructure\UI\Form\Filter;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Util\StringUtil;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseFilterType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
    }

    public function getBlockPrefix()
    {
        return StringUtil::fqcnToBlockPrefix(static::class) ?: '';
    }

    public function getParent()
    {
        return FormType::class;
    }
}
