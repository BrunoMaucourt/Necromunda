<?php

namespace App\Controller\Admin;

use App\EasyAdmin\ScenarioField;
use App\Entity\Game;
use App\Enum\ScenariosEnum;
use App\Repository\GangRepository;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class GamesCrudController extends AbstractCrudController
{
    private Security $security;
    private AdminUrlGenerator $adminUrlGenerator;

    private RequestStack $requestStack;

    public function __construct(
        RequestStack $requestStack,
        Security $security,
        GangRepository $gangRepository,
        AdminUrlGenerator $adminUrlGenerator
    ){
        $this->security = $security;
        $this->requestStack = $requestStack;
        $this->gangRepository = $gangRepository;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        if (
            $pageName === Crud::PAGE_NEW
        ) {
            $session = $this->requestStack->getSession();
            $gang1Id = $session->get('gang1');
            $gang2Id = $session->get('gang2');
        } elseif (
            $pageName === Crud::PAGE_EDIT ||
            $pageName === Crud::PAGE_DETAIL
        ) {
            $game = $this->getContext()->getEntity()->getInstance();

            if ($game instanceof Game) {
                $gang1Id = $game->getGang1() ? $game->getGang1()->getId() : null;
                $gang2Id = $game->getGang2() ? $game->getGang2()->getId() : null;
            }
        } else {
            $gang1Id = null;
            $gang2Id = null;
        }

        $gangs = [$gang1Id, $gang2Id];

        yield ScenarioField::new('scenario', 'Scenario')
            ->hideWhenCreating()
            ->formatValue(static function (ScenariosEnum $scenariosEnum): string {
                return $scenariosEnum->enumToString();
            })
            ->setColumns(6);
        yield DateField::new('date')
            ->setColumns(6);
        yield FormField::addPanel('Players')
            ->hideWhenCreating()
            ->setIcon('fa fa-users')
            ->collapsible();
        yield AssociationField::new('gang1')
            ->hideWhenCreating()
            ->setColumns(6)
            ->setFormTypeOption('disabled','disabled')
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) use ($gang1Id) {
                    return $er->createQueryBuilder('g')
                        ->where('g.id = :id')
                        ->setParameter('id', $gang1Id);
                },
            ]);
        yield AssociationField::new('gang2')
            ->hideWhenCreating()
            ->setColumns(6)
            ->setFormTypeOption('disabled','disabled')
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) use ($gang2Id) {
                    return $er->createQueryBuilder('g')
                        ->where('g.id = :id')
                        ->setParameter('id', $gang2Id);
                },
            ]);
//        yield FormField::addPanel('Gangers involved in game')
//            ->hideWhenCreating()
//            ->setIcon('fa fa-user-secret')
//            ->collapsible();
//        yield AssociationField::new('gangers')
//            ->hideWhenCreating()
//            ->hideOnIndex()
//            ->setLabel('Ganger 1')
//            ->setColumns(6)
//            ->setFormTypeOptions([
//                'query_builder' => function (EntityRepository $er) use ($gang1Id) {
//                    return $er->createQueryBuilder('g')
//                        ->where('g.gang1 = :gang')
//                        ->setParameter('gang', $gang1Id);
//                },
//            ]);
//        yield AssociationField::new('gangers')
//            ->hideWhenCreating()
//            ->hideOnIndex()
//            ->setLabel('Ganger 2')
//            ->setColumns(6)
//            ->setFormTypeOptions([
//                'query_builder' => function (EntityRepository $er) use ($gang2Id) {
//                    return $er->createQueryBuilder('g')
//                        ->where('g.gang2 = :gang')
//                        ->setParameter('gang', $gang2Id);
//                },
//            ]);
        yield FormField::addPanel('Injuries during game')
            ->hideWhenCreating()
            ->setIcon('fa fa-user-injured')
            ->collapsible();
        yield AssociationField::new('injuries')
            ->setLabel('Gang 1')
            ->hideWhenCreating()
            ->hideOnIndex()
            ->setColumns(6)->setColumns(6)->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) use ($gang1Id) {
                    return $er->createQueryBuilder('g')
                        ->where('g.id = :id')
                        ->setParameter('id', $gang1Id);
                },
            ]);
        yield AssociationField::new('injuries')
            ->setLabel('Gang 2')
            ->hideWhenCreating()
            ->hideOnIndex()
            ->setColumns(6)->setColumns(6)->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) use ($gang2Id) {
                    return $er->createQueryBuilder('g')
                        ->where('g.id = :id')
                        ->setParameter('id', $gang2Id);
                },
            ]);
//        yield FormField::addPanel('Territories exploited by gangers')
//            ->setIcon('fa fa-warehouse')
//            ->hideWhenCreating()
//            ->collapsible();
//        yield AssociationField::new('territories')
//            ->setColumns(6)
//            ->hideWhenCreating()
//            ->setFormTypeOptions([
//                'query_builder' => function (EntityRepository $er) use ($gang1Id) {
//                    return $er->createQueryBuilder('g')
//                        ->where('g.gang = :gang')
//                        ->setParameter('gang', $gang1Id);
//                },
//            ]);
//        yield AssociationField::new('territories')
//            ->setColumns(6)
//            ->hideWhenCreating()
//            ->setFormTypeOptions([
//                'query_builder' => function (EntityRepository $er) use ($gang2Id) {
//                    return $er->createQueryBuilder('g')
//                        ->where('g.gang = :gang')
//                        ->setParameter('gang', $gang2Id);
//                },
//            ]);
        yield FormField::addPanel('Score')
            ->hideWhenCreating()
            ->setIcon('fa fa-list-ol')
            ->collapsible();
        yield IntegerField::new('getGang1RatingBeforeGame')
            ->hideOnIndex()
            ->hideWhenCreating()
            ->setColumns(6)
            ->hideOnIndex();
        yield IntegerField::new('getGang1RatingAfterGame')
            ->hideWhenCreating()
            ->setLabel('Gang 1 rating after game')
            ->setColumns(6);
        yield IntegerField::new('getGang2RatingBeforeGame')
            ->hideOnIndex()
            ->hideWhenCreating()
            ->setColumns(6);
        yield IntegerField::new('getGang2RatingAfterGame')
            ->hideWhenCreating()
            ->setLabel('Gang 2 rating after game')
            ->setColumns(6);
        yield FormField::addPanel('Credits and loots')
            ->hideWhenCreating()
            ->setIcon('fa fa-gem')
            ->collapsible();
        yield NumberField::new('gang1creditsBeforeGame')
            ->hideOnIndex()
            ->hideWhenCreating()
            ->setColumns(6)
            ->hideOnIndex();
        yield NumberField::new('gang2creditsBeforeGame')
            ->hideOnIndex()
            ->hideWhenCreating()
            ->setColumns(6)
            ->hideOnIndex();
        yield NumberField::new('gang1creditsAfterGame')
            ->hideWhenCreating()
            ->setColumns(6);
        yield NumberField::new('gang2creditsAfterGame')
            ->hideWhenCreating()
            ->setColumns(6);
//        yield AssociationField::new('loots')
//            ->hideWhenCreating()
//            ->hideOnIndex()
//            ->setColumns(6)
//            ->hideOnIndex()
//            ->setFormTypeOptions([
//                'query_builder' => function (EntityRepository $er) use ($gang1Id) {
//                    return $er->createQueryBuilder('g')
//                        ->where('g.gang = :gang')
//                        ->setParameter('gang', $gang1Id);
//                },
//            ]);
//        yield AssociationField::new('loots')
//            ->hideWhenCreating()
//            ->hideOnIndex()
//            ->setColumns(6)
//            ->hideOnIndex()
//            ->setFormTypeOptions([
//                'query_builder' => function (EntityRepository $er) use ($gang2Id) {
//                    return $er->createQueryBuilder('g')
//                        ->where('g.gang = :gang')
//                        ->setParameter('gang', $gang2Id);
//                },
//            ]);
        yield FormField::addPanel('Winner')
            ->setIcon('fa fa-trophy')
            ->collapsible();
        yield AssociationField::new('winner')
            ->setColumns(6)
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) use ($gangs) {
                    return $er->createQueryBuilder('g')
                        ->where('g.id IN (:ids)')
                        ->setParameter('ids', $gangs);
                },
            ]);
        yield FormField::addPanel('Game background and details')
            ->setIcon('fa fa-book')
            ->collapsible();
        yield TextareaField::new('background')
            ->setColumns(12)
            ->hideOnIndex();
        yield TextareaField::new('summary')
            ->setColumns(12)
            ->hideWhenCreating()
            ->hideOnIndex()
            ->renderAsHtml();
        yield TextareaField::new('history')
            ->setColumns(12)
            ->hideWhenCreating()
            ->hideOnIndex();
    }
    public function configureActions(Actions $actions): Actions
    {
        $urlForCustomNewGameAction = $this->adminUrlGenerator
            ->setRoute('choose_gangs')
            ->generateUrl();
        $customNewGameAction = Action::new('newGame', 'Add game')
            ->linkToUrl($urlForCustomNewGameAction)
            ->setCssClass('btn btn-primary')
            ->createAsGlobalAction();

        return $actions
            ->add(Crud::PAGE_INDEX, $customNewGameAction)
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
                        return self::checkGamesOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->addCssClass('btn btn-light btn-remove-margin')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkGamesOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-file-alt')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkGamesOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkGamesOfCurrentUser($entity, $security);
                    });
            })
            ->remove(Crud::PAGE_INDEX, Action::NEW)
        ;
    }

    public static function checkGamesOfCurrentUser(Game $game, $security): bool
    {
        if(
            $game->getGang1()->getUser() == $security->getUser()
            || $game->getGang2()->getUser() == $security->getUser()
            || $security->isGranted('ROLE_ADMIN')
        ) {
            return true;
        }

        return false;
    }
}