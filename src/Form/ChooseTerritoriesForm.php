<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseTerritoriesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gang1territories', ChoiceType::class, [
                'choices' => $options['gang1territories'],
                'choice_label' => function($territory) {
                    return $territory->getNameAsString() . '<br>'. 'credits = ' . $territory->getIncomeAsString() . '<br>'. $territory->getEffect();
                },
                'choice_value' => function($territory) {
                    return $territory ? $territory->getId() : '';
                },
                'label' => "Choose gang 1 territories (max " . $options['gang1MaxTerritoriesExploited'] . ")",
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'data-max-options' => $options['gang1MaxTerritoriesExploited'],
                ],
            ])
            ->add('gang2territories', ChoiceType::class, [
                'choices' => $options['gang2territories'],
                'choice_label' => function($territory) {
                    return $territory->getNameAsString() . '<br>'. 'credits = ' . $territory->getIncomeAsString() . '<br>'. $territory->getEffect();
                },
                'choice_value' => function($territory) {
                    return $territory ? $territory->getId() : '';
                },
                'label' => "Choose gang 2 territories (max " . $options['gang2MaxTerritoriesExploited'] . ")",
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'data-max-options' => $options['gang2MaxTerritoriesExploited'],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);

        $resolver->setRequired([
            'gang1territories',
            'gang2territories',
            'gang1MaxTerritoriesExploited',
            'gang2MaxTerritoriesExploited'
        ]);
        $resolver->setAllowedTypes('gang1territories', 'Doctrine\Common\Collections\Collection');
        $resolver->setAllowedTypes('gang2territories', 'Doctrine\Common\Collections\Collection');
        $resolver->setAllowedTypes('gang1MaxTerritoriesExploited', 'int');
        $resolver->setAllowedTypes('gang2MaxTerritoriesExploited', 'int');
    }
}