<?php

namespace App\Controller\Admin;

use App\EasyAdmin\HouseField;
use App\Entity\Gang;
use App\Enum\HouseEnum;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;

class GangCrudController extends AbstractCrudController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Gang::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield HouseField::new('house', 'House')
            ->formatValue(static function (HouseEnum $houseEnum): string {
                return $houseEnum->enumToString();
            })
            ->setColumns(4);
        yield TextField::new('name')
            ->setColumns(4);
        yield AssociationField::new('user')
            ->setColumns(4)
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->where('g.username = :username')
                        ->setParameter('username', $this->getUser()->getUsername());
                },
            ]);
        if ($pageName !== Crud::PAGE_NEW) {
            yield FormField::addPanel('Gang status')
                ->setIcon('fa fa-chart-simple')
                ->collapsible();
            yield IntegerField::new('rating')
                ->setColumns(4)
                ->setFormTypeOption('disabled','disabled')
                ->setThousandsSeparator(' ');
            yield IntegerField::new('credits')
                ->setColumns(4)
                ->setThousandsSeparator(' ');
            yield BooleanField::new('active')
                ->setColumns(4)
                ->renderAsSwitch(false);
            yield FormField::addPanel('Gangers and territories')
                ->setIcon('fa fa-user-secret')
                ->collapsible();

            if ($pageName == Crud::PAGE_DETAIL) {
                yield CollectionField::new('gangers')
                    ->setColumns(6)
                    ->hideOnIndex();
                yield CollectionField::new('territories')
                    ->setColumns(6)
                    ->hideOnIndex();
            } else {
                yield CollectionField::new('gangers')
                    ->setColumns(12)
                    ->hideOnIndex()
                    ->useEntryCrudForm(GangerCrudController::class);
                yield CollectionField::new('territories')
                    ->setColumns(12)
                    ->hideOnIndex()
                    ->useEntryCrudForm(TerritoriesCrudController::class);
            }
            yield FormField::addPanel('Gang fights')
                ->setIcon('fa fa-dice')
                ->collapsible();
            if ($pageName == Crud::PAGE_DETAIL) {
                yield CollectionField::new('games')
                    ->setColumns(6)
                    ->hideOnIndex();
                yield CollectionField::new('win')
                    ->setColumns(6)
                    ->hideOnIndex();
            } else {
                yield CollectionField::new('games')
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->setFormTypeOption('disabled','disabled');
                yield CollectionField::new('win')
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->setFormTypeOption('disabled','disabled');
            }
        }
        yield FormField::addPanel('Gang background')
            ->setIcon('fa fa-book')
            ->collapsible();
        yield TextareaField::new('background')
            ->setColumns(12)
            ->hideOnIndex();
        yield FormField::addPanel('Gang history')
            ->setIcon('fa-solid fa-clock-rotate-left')
            ->hideWhenCreating()
            ->collapsible();
        yield TextareaField::new('history')
            ->setColumns(12)
            ->hideWhenCreating()
            ->hideOnIndex();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye')
                    ->setCssClass('btn btn-light btn-remove-margin');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-pen-to-square')
                    ->setCssClass('btn btn-light btn-remove-margin')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkGangOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->addCssClass('btn btn-light btn-remove-margin')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkGangOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-file-alt')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkGangOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-user')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkGangOfCurrentUser($entity, $security);
                    });
            })
        ;
    }

    public static function checkGangOfCurrentUser(Gang $gang, $security): bool
    {
        if(
            $gang->getUser() == $security->getUser()
            || $security->isGranted('ROLE_ADMIN')
        ) {
            return true;
        }

        return false;
    }
}