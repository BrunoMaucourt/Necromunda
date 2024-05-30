<?php

namespace App\Controller\Admin;

use App\EasyAdmin\GangerTypeField;
use App\Entity\Ganger;
use App\Enum\GangerTypeEnum;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use \Symfony\Bundle\SecurityBundle\Security;

class GangerCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public static function getEntityFqcn(): string
    {
        return Ganger::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('gang')
            ->add('type')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        if ($pageName === Crud::PAGE_NEW) {
            yield TextField::new('name')
                ->setColumns(6);
            yield AssociationField::new('gang')
                ->setColumns(6)
                ->setFormTypeOptions([
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                            ->where('g.user = :user')
                            ->setParameter('user', $this->getUser());
                    },
                ]);
            yield GangerTypeField::new('type', 'Ganger type')
                ->formatValue(static function (GangerTypeEnum $gangerType): string {
                    return $gangerType->enumToString();
                })
                ->setColumns(6);
        } else {
            yield AssociationField::new('gang')
                ->setColumns(6)
                ->onlyOnIndex();
            yield GangerTypeField::new('type', 'Ganger type')
                ->formatValue(static function (GangerTypeEnum $gangerType): string {
                    return $gangerType->enumToString();
                })
                ->setColumns(3);
            yield TextField::new('name')
                ->setColumns(6)
                ->hideOnIndex();
            yield TextField::new('name')
                ->onlyOnIndex()
                ->setTemplatePath('admin/fields/nameAsLink.html.twig');
            yield BooleanField::new('alive')
                ->setColumns(3)
                ->renderAsSwitch(false);
            yield FormField::addPanel('Characteristics')
                ->setIcon('fa fa-list-ol')
                ->collapsible();
            yield IntegerField::new('move')
                ->setColumns(3);
            yield IntegerField::new('weaponSkill')
                ->setColumns(3);
            yield IntegerField::new('ballisticSkill')
                ->setColumns(3);
            yield IntegerField::new('strength')
                ->setColumns(3);
            yield IntegerField::new('toughness')
                ->setColumns(3);
            yield IntegerField::new('wounds')
                ->setColumns(3);
            yield IntegerField::new('initiative')
                ->setColumns(3);
            yield IntegerField::new('attacks')
                ->setColumns(3);
            yield IntegerField::new('leadership')
                ->setColumns(3);
            yield IntegerField::new('experience')
                ->setColumns(3);
            yield IntegerField::new('rating')
                ->setColumns(3);
            yield FormField::addPanel('Injuries and skills')
                ->setIcon('fa fa-info')
                ->collapsible();
            if ($pageName == Crud::PAGE_DETAIL) {
                yield CollectionField::new('injuries')
                    ->setColumns(6)
                    ->hideOnIndex();
                yield CollectionField::new('skills')
                    ->setColumns(6)
                    ->hideOnIndex();
            } else {
                yield CollectionField::new('injuries')
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->useEntryCrudForm(InjuriesCrudController::class);
                yield CollectionField::new('skills')
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->useEntryCrudForm(SkillsCrudController::class);
            }
            yield FormField::addPanel('Weapons and equipements')
                ->setIcon('fa fa-gun')
                ->collapsible();
            if ($pageName == Crud::PAGE_DETAIL) {
                yield CollectionField::new('weapons')
                    ->setColumns(6)
                    ->hideOnIndex();
                yield CollectionField::new('equipements')
                    ->setColumns(6)
                    ->hideOnIndex();
            } else {
                yield CollectionField::new('weapons')
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->useEntryCrudForm(WeaponsCrudController::class);
                yield CollectionField::new('equipements')
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->useEntryCrudForm(EquipementsCrudController::class);
            }
            yield FormField::addPanel('Ganger background')
                ->setIcon('fa fa-book')
                ->collapsible();
            yield TextareaField::new('background')
                ->setColumns(12)
                ->hideOnIndex();
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
                    return self::checkGangsOfCurrentUser($entity, $security);
                });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->displayIf(static function ($entity) use ($security) {
                    return self::checkGangsOfCurrentUser($entity, $security);
                });
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-file-alt')
                    ->displayIf(static function ($entity) use ($security) {
                    return self::checkGangsOfCurrentUser($entity, $security);
                });
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-user')
                    ->displayIf(static function ($entity) use ($security) {
                    return self::checkGangsOfCurrentUser($entity, $security);
                });
            })
        ;
    }

    public static function checkGangsOfCurrentUser(Ganger $ganger, $security): bool
    {
        if(
            $ganger->getGang()->getUser() == $security->getUser()
            || $security->isGranted('ROLE_ADMIN')
        ) {
            return true;
        }

        return false;
    }
}