<?php

namespace App\Controller\Admin;

use App\EasyAdmin\LootField;
use App\Entity\Loot;
use App\Enum\LootEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class LootCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Loot::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield LootField::new('name')
            ->formatValue(static function (LootEnum $lootEnum): string {
                return $lootEnum->enumToString();
            });
        yield IntegerField::new('cost');
        yield AssociationField::new('gang');
        yield AssociationField::new('game');
    }
}
