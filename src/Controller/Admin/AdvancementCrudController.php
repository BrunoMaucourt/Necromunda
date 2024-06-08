<?php

namespace App\Controller\Admin;

use App\Entity\Advancement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdvancementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Advancement::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
