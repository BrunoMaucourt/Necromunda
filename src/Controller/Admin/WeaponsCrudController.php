<?php

namespace App\Controller\Admin;

use App\EasyAdmin\WeaponsField;
use App\Entity\Ganger;
use App\Entity\Weapon;
use App\Enum\WeaponsEnum;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Bundle\SecurityBundle\Security;

class WeaponsCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security){
        $this->security = $security;
    }
    public static function getEntityFqcn(): string
    {
        return Weapon::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('ganger')
            ->add('cost')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $object = $this->getContext()->getEntity()->getInstance();

        yield WeaponsField::new('name', 'Name')
            ->formatValue(static function (WeaponsEnum $weaponsEnums): string {
                return $weaponsEnums->enumToString();
            })
            ->setColumns(4);
        if (
            $pageName === Crud::PAGE_NEW &&
            $object instanceof Ganger
        ) {
            $ganger = $object;

            yield AssociationField::new('ganger')
                ->setColumns(4)
                ->setFormTypeOptions([
                    'query_builder' => function (EntityRepository $er) use ($ganger) {
                        return $er->createQueryBuilder('g')
                            ->where('g.id = :id')
                            ->setParameter('id', $ganger->getId())
                        ;
                    },
                    'data' => $ganger,
                ]);
        } else {
            if ($this->security->isGranted('ROLE_ADMIN')) {
                yield AssociationField::new('ganger')
                    ->setColumns(4)
                ;
            } else {
                yield AssociationField::new('ganger')
                    ->setColumns(4)
                    ->setFormTypeOptions([
                        'query_builder' => function (EntityRepository $er)  {
                            return $er->createQueryBuilder('g')
                                ->join('g.gang', 'gang')
                                ->where('gang.user = :user')
                                ->setParameter('user', $this->getUser())
                            ;
                        },
                    ])
                ;
            }
        }
        yield AssociationField::new('equipements')
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
                        return self::checkWeaponsOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkWeaponsOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-file-alt')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkWeaponsOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-user')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkWeaponsOfCurrentUser($entity, $security);
                    });
            })
            ;
    }

    public static function checkWeaponsOfCurrentUser(Weapon $weapon, $security): bool
    {
        if( $security->isGranted('ROLE_ADMIN') ) {
            return true;
        }

        if( $weapon->getGanger() ) {
            if ( $weapon->getGanger()->getGang()->getUser() == $security->getUser() ) {
                return true;
            }
        }

        if( $weapon->getStash() ) {
            if ( $weapon->getStash()->getUser() == $security->getUser() ) {
                return true;
            }
        }

        return false;
    }
}