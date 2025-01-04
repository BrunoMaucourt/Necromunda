<?php

namespace App\Controller\Admin;

use App\Entity\Advancement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdvancementCrudController extends AbstractCrudController
{
    private TranslatorInterface $translator;

    public function __construct(
        TranslatorInterface $translator,
    ) {
        $this->translator = $translator;
    }

    public static function getEntityFqcn(): string
    {
        return Advancement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('ganger', $this->translator->trans('Ganger'));

        yield TextField::new('content', $this->translator->trans('Content'));

        yield AssociationField::new('game', $this->translator->trans('Game'));

        yield AssociationField::new('skill', $this->translator->trans('Skill'));
    }
}
