<?php

namespace App\Form;

use App\Enum\ScenariosEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseScenarioForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('scenario', ChoiceType::class, [
                'choices' => $this->getScenarioChoices(),
                'label' => 'Choose Scenario',
                'attr' => [
                    'class' => 'm-5',
                ],
            ])
        ;
    }

    private function getScenarioChoices(): array
    {
        $choices = [];
        foreach (ScenariosEnum::cases() as $scenario) {
            $choices[$scenario->enumToString()] = $scenario;
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}