<?php

namespace App\Controller\Admin;

use App\Entity\Loot;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LootCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Loot::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield IntegerField::new('cost');
        yield AssociationField::new('gang');
        yield AssociationField::new('game');
    }
}
