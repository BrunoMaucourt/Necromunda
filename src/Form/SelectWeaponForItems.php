<?php
namespace App\Form;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Weapon;
use Symfony\Contracts\Translation\TranslatorInterface;

class SelectWeaponForItems extends AbstractType
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Weapon $weapons */
        $weapons = $options['weapons'];

        $choices = [];
        foreach ($weapons as $weapon) {
            dump($weapon->getGanger());
            if ($weapon->getGanger()) {
                $choices[$weapon->getName()->enumToString() . ' - ' . $weapon->getGanger()->getName() . " (". $weapon->getGanger()->getType()->enumToString() .")"] = $weapon->getId();
            } else {
                $choices[$weapon->getName()->enumToString() . ' - ' . $this->translator->trans("Stash")] = $weapon->getId();
            }
        }

        $builder->add('weapon', ChoiceType::class, [
            'choices' => $choices,
            'label' => 'Select weapon',
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

        $resolver->setRequired(['weapons']);
        $resolver->setAllowedTypes('weapons', 'array');
    }
}