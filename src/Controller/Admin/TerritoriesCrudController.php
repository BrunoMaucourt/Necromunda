<?php

namespace App\Controller\Admin;

use App\EasyAdmin\TerritoriesField;
use App\Entity\Territories;
use App\Enum\TerritoriesEnum;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TerritoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Territories::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('gang')
            ->setColumns(3)
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->where('g.user = :user')
                        ->setParameter('user', $this->getUser());
                },
            ]);
        yield TerritoriesField::new('name', 'territories name')
            ->formatValue(static function (TerritoriesEnum $territories): string {
                return $territories->enumToString();
            })
            ->setColumns(3);
        if ($pageName !== Crud::PAGE_NEW) {
            yield TextField::new('incomeAsString')
                ->setLabel('income')
                ->setColumns(6)
                ->setFormTypeOption('disabled','disabled');
        }
        yield TextField::new('effect')
            ->setColumns(6)
        ;
    }
}