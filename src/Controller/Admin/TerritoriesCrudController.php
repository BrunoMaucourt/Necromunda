<?php

namespace App\Controller\Admin;

use App\EasyAdmin\TerritoriesField;
use App\Entity\Territory;
use App\Enum\TerritoriesEnum;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;

class TerritoriesCrudController extends AbstractCrudController
{
    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Territory::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('gang')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('gang')
            ->setColumns(4)
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
            ->setColumns(4);
        if ($pageName !== Crud::PAGE_NEW) {
            yield TextField::new('incomeAsString')
                ->setLabel('Income')
                ->setColumns(4)
                ->setFormTypeOption('disabled','disabled');
            yield TextField::new('effect')
                ->setColumns(6)
                ->setFormTypeOption('disabled','disabled');
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-pen-to-square')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkTerritoriesOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkTerritoriesOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-file-alt')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkTerritoriesOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-user')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkTerritoriesOfCurrentUser($entity, $security);
                    });
            })
            ;
    }

    public static function checkTerritoriesOfCurrentUser(Territory $territory, $security): bool
    {
        if(
            $territory->getGang()->getUser() == $security->getUser()
            || $security->isGranted('ROLE_ADMIN')
        ) {
            return true;
        }

        return false;
    }
}