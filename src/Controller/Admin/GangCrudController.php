<?php

namespace App\Controller\Admin;

use App\Entity\Gang;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GangCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gang::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name')
            ->setColumns(6);
        yield AssociationField::new('user')
            ->setColumns(6);
        yield NumberField::new('rating')
            ->setColumns(6);
        yield NumberField::new('credits')
            ->setColumns(6);
        yield BooleanField::new('status')
            ->setColumns(6);
        yield TextareaField::new('background')
            ->setColumns(6);
        yield CollectionField::new('gangers')
            ->setColumns(6);
        yield CollectionField::new('territories')
            ->setColumns(6);
        yield CollectionField::new('games')
            ->setColumns(6);
        yield CollectionField::new('win')
            ->setColumns(6);
    }
}