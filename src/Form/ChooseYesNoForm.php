<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseYesNoForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('yes', SubmitType::class, [
                'label' => 'Yes',
                'attr' => [
                    'class' => 'btn btn-success',
                ],
            ])
            ->add('no', SubmitType::class, [
                'label' => 'No',
                'attr' => [
                    'class' => 'btn btn-danger',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
