<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Ganger;

class SelectGangerForItems extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Ganger $gangers */
        $gangers = $options['gangers'];

        $choices = [];
        foreach ($gangers as $ganger) {
            $choices[$ganger->getName() . ' - ' . $ganger->getType()->enumToString()] = $ganger->getId();
        }

        $builder->add('ganger', ChoiceType::class, [
            'choices' => $choices,
            'label' => 'Select Ganger',
            'expanded' => true,
            'multiple' => false,
            'attr' => [
                'class' => 'mt-2 mb-3',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);

        $resolver->setRequired(['gangers']);
        $resolver->setAllowedTypes('gangers', 'array');
    }
}