<?php

namespace App\Form;

use App\Entity\Weapon;
use App\Enum\WeaponsEnum;
use App\Entity\Ganger;
use App\Entity\Gang;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeaponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', ChoiceType::class, [
                'choices' => WeaponsEnum::cases(),
                'choice_label' => fn(WeaponsEnum $enum) => $enum->enumToString(),
                'label' => 'Weapon Name',
                'required' => true,
            ])
            ->add('ganger', EntityType::class, [
                'class' => Ganger::class,
                'choice_label' => 'name',
                'label' => 'Associated Ganger',
                'required' => false,
                'placeholder' => 'None',
            ])
            ->add('stash', EntityType::class, [
                'class' => Gang::class,
                'choice_label' => 'name',
                'label' => 'Stash (Gang)',
                'required' => false,
                'placeholder' => 'None',
            ])
            ->add('loot', CheckboxType::class, [
                'label' => 'Is Loot?',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Weapon::class,
        ]);
    }
}
