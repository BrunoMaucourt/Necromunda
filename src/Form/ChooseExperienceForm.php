<?php

namespace App\Form;

use App\Entity\Ganger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ChooseExperienceForm extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $gangerRepository = $this->entityManager->getRepository(Ganger::class);

        $gangers1 = $options['gangers1'];
        $gangers2 = $options['gangers2'];

        $builder->add('gang1', FormType::class, ['label' => false]);
        foreach ($gangers1 as $ganger) {
            $builder->get('gang1')->add($ganger->getId(), IntegerType::class, [
                'label' => $ganger->getName(),
                'data' => 0,
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ],
                'constraints' => [
                    new Assert\Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' => 'Experience must be between {{ min }} and {{ max }}.',
                    ]),
                ],
            ]);
        }

        $builder->add('gang2', FormType::class, ['label' => false]);
        foreach ($gangers2 as $ganger) {
            $builder->get('gang2')->add($ganger->getId(), IntegerType::class, [
                'label' => $ganger->getName(),
                'data' => 0,
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ],
                'constraints' => [
                    new Assert\Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' => 'Experience must be between {{ min }} and {{ max }}.',
                    ]),
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