<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseBionic extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $bionics = $options['bionics'];

        $choices = [];
        foreach ($bionics as $bionic) {
            $choices[$bionic->enumToString()] = $bionic->enumToString();
        }

        $builder->add('bionic', ChoiceType::class, [
            'choices' => $choices,
            'expanded' => true,
            'multiple' => false,
            'label' => false,
            'choice_attr' => function ($choice, $key, $value) use ($bionics) {
                $bionic = null;
                foreach ($bionics as $b) {
                    if ((string)$b->enumToString() === (string)$value) {
                        $bionic = $b;
                        break;
                    }
                }
                return [
                    'data-description' => $bionic ? $bionic->getDescription() : '',
                    'data-cost' => $bionic ? $bionic->getFixedCost() : '',
                    'data-dice' => $bionic ? $bionic->getVariableDicesNumber() : '',
                ];
            },
            'attr' => [
                'class' => 'mt-2 mb-3 bionics-radio-group',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);

        $resolver->setRequired(['bionics']);
        $resolver->setAllowedTypes('bionics', 'array');
    }
}