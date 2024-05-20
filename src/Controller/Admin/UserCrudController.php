<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('username')
            ->setColumns(6);
        yield CollectionField::new('gang')
            ->setColumns(6);
        if($this->isGranted('ROLE_ADMIN')){
            yield ArrayField::new('roles')
                ->setColumns(6);
        }
        yield TextField::new('password')
            ->hideOnIndex();
    }
}