<?php

namespace App\Form;

use App\Entity\Gang;
use App\Enum\ScenariosEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseGangsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gang1', EntityType::class, [
                'class' => Gang::class,
                'choice_label' => 'name',
                'label' => 'Choose Gang 1',
                'attr' => [
                    'class' => 'm-5',
                ],
            ])
            ->add('gang2', EntityType::class, [
                'class' => Gang::class,
                'choice_label' => 'name',
                'label' => 'Choose Gang 2',
                'attr' => [
                    'class' => 'm-5',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}