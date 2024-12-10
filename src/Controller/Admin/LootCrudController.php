<?php

namespace App\Controller\Admin;

use App\EasyAdmin\LootField;
use App\Entity\Gang;
use App\Entity\Loot;
use App\Enum\LootEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class LootCrudController extends AbstractCrudController
{
    private Security $security;

    private TranslatorInterface $translator;

    public function __construct(
        Security $security,
        TranslatorInterface $translator
    ){
        $this->security = $security;
        $this->translator = $translator;
    }

    public static function getEntityFqcn(): string
    {
        return Loot::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield LootField::new('name', $this->translator->trans('name'))
            ->formatValue(static function (LootEnum $lootEnum): string {
                return $lootEnum->enumToString();
            });
        yield IntegerField::new('cost', $this->translator->trans('cost'));
        yield AssociationField::new('gang', $this->translator->trans('gang'));
        yield AssociationField::new('game', $this->translator->trans('game'));

        if ($this->security->isGranted('ROLE_ADMIN')) {
            yield BooleanField::new('active', $this->translator->trans('active'));
        }
    }
}
