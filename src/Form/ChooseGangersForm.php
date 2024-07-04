<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Ganger;

class ChooseGangersForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Ganger $gangers1 */
        $gangers1 = $options['gangers1'];
        /** @var Ganger $gangers2 */
        $gangers2 = $options['gangers2'];

        $allChoices = [
            'Not involved' => 'not_involved',
            'Involved and safe' => 'involved_safe',
            'Involved and injuries' => 'involved_injuries',
            'Involved and high impact injuries' => 'involved_high_impact_injuries'
        ];

        $builder->add('gang1', FormType::class, ['label' => false]);
        foreach ($gangers1 as $ganger) {
            $builder->get('gang1')->add($ganger->getId(), ChoiceType::class, [
                'label' => $ganger->getName() . ' - ' . $ganger->getType()->enumToString(),
                'choices' => $allChoices,
                'expanded' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'mt-2 mb-3',
                ],
            ]);
        }

        $builder->add('gang2', FormType::class, ['label' => false]);
        foreach ($gangers2 as $ganger) {
            $builder->get('gang2')->add($ganger->getId(), ChoiceType::class, [
                'label' => $ganger->getName() . ' - ' . $ganger->getType()->enumToString(),
                'choices' => $allChoices,
                'expanded' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'mt-2 mb-3',
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);

        $resolver->setRequired(['gangers1', 'gangers2']);
        $resolver->setAllowedTypes('gangers1', 'array');
        $resolver->setAllowedTypes('gangers2', 'array');
    }
}