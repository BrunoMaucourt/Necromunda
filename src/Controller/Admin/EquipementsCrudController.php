<?php

namespace App\Controller\Admin;

use App\EasyAdmin\EquipementsField;
use App\EasyAdmin\WeaponsField;
use App\Entity\Equipements;
use App\Entity\Weapons;
use App\Enum\EquipementsEnum;
use App\Enum\WeaponsEnum;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Bundle\SecurityBundle\Security;

class EquipementsCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security){
        $this->security = $security;
    }
    public static function getEntityFqcn(): string
    {
        return Equipements::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield EquipementsField::new('name', 'Name')
            ->formatValue(static function (EquipementsEnum $equipementsEnum): string {
                return $equipementsEnum->enumToString();
            })
            ->setColumns(4);
        yield AssociationField::new('ganger')
            ->setColumns(4)
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->join('g.gang', 'gang')
                        ->where('gang.user = :user')
                        ->setParameter('user', $this->getUser());
                },
            ]);
        yield AssociationField::new('weapon')
            ->setColumns(4)
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->join('e.ganger', 'g')
                        ->join('g.gang', 'gang')
                        ->join('gang.user', 'user')
                        ->where('user = :user')
                        ->setParameter('user', $this->getUser());
                },
            ]);
        yield IntegerField::new('cost')
            ->setColumns(4);
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
                        return self::checkEquipementsOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkEquipementsOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-file-alt')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkEquipementsOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-user')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkEquipementsOfCurrentUser($entity, $security);
                    });
            })
            ;
    }

    public static function checkEquipementsOfCurrentUser(Equipements $equipements, $security): bool
    {
        if(
            $equipements->getGanger()->getGang()->getUser() == $security->getUser()
            || $security->isGranted('ROLE_ADMIN')
        ) {
            return true;
        }

        return false;
    }
}