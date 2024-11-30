<?php

namespace App\Controller\Admin;

use App\EasyAdmin\ScenarioField;
use App\Entity\CustomRules;
use App\Entity\Game;
use App\Enum\ScenariosEnum;
use App\service\CsvExporterService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class GamesCrudController extends AbstractCrudController
{
    private AdminUrlGenerator $adminUrlGenerator;

    private EntityManagerInterface $entityManager;

    private FilterFactory $filterFactory;

    private RequestStack $requestStack;

    private Security $security;

    private TranslatorInterface $translator;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager,
        FilterFactory $filterFactory,
        RequestStack $requestStack,
        Security $security,
        TranslatorInterface $translator
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
        $this->filterFactory = $filterFactory;
        $this->security = $security;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
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
        $customRulesRepository = $this->entityManager->getRepository(CustomRules::class);
        $customRulesArray = $customRulesRepository->findAll();
        if ($customRulesArray) {
            $customRules = $customRulesArray[0];
        }

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

        if ($customRulesArray) {
            yield ScenarioField::new('scenario', $this->translator->trans('Scenario'))
                ->setCustomRules($customRules)
                ->hideWhenCreating()
                ->formatValue(static function (ScenariosEnum $scenariosEnum): string {
                    return $scenariosEnum->enumToString();
                })
                ->setColumns(6)
            ;
        } else {
            yield ScenarioField::new('scenario', $this->translator->trans('Scenario'))
                ->hideWhenCreating()
                ->formatValue(static function (ScenariosEnum $scenariosEnum): string {
                    return $scenariosEnum->enumToString();
                })
                ->setColumns(6)
            ;
        }

        yield DateField::new('date', $this->translator->trans('date'))
            ->setColumns(6);
        yield FormField::addPanel('Players', $this->translator->trans('Players'))
            ->hideWhenCreating()
            ->setIcon('fa fa-users')
            ->collapsible();
        yield AssociationField::new('gang1', $this->translator->trans('gang1'))
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
        yield AssociationField::new('gang2', $this->translator->trans('gang2'))
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
        yield FormField::addPanel($this->translator->trans('Injuries during game'))
            ->hideWhenCreating()
            ->setIcon('fa fa-user-injured')
            ->collapsible();
        yield AssociationField::new('injuries', $this->translator->trans('injuries gang 1'))
            ->hideWhenCreating()
            ->hideOnIndex()
            ->setColumns(6)->setColumns(6)->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) use ($gang1Id) {
                    return $er->createQueryBuilder('g')
                        ->where('g.id = :id')
                        ->setParameter('id', $gang1Id);
                },
            ]);
        yield AssociationField::new('injuries', $this->translator->trans('injuries gang 2'))
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
        yield FormField::addPanel('Score', $this->translator->trans('Score'))
            ->hideWhenCreating()
            ->setIcon('fa fa-list-ol')
            ->collapsible();
        yield IntegerField::new('getGang1RatingBeforeGame', $this->translator->trans('getGang1RatingBeforeGame'))
            ->hideOnIndex()
            ->hideWhenCreating()
            ->setColumns(6)
            ->hideOnIndex();
        yield IntegerField::new('getGang1RatingAfterGame', $this->translator->trans('Gang 1 rating after game'))
            ->hideWhenCreating()
            ->setColumns(6);
        yield IntegerField::new('getGang2RatingBeforeGame', $this->translator->trans('getGang2RatingBeforeGame'))
            ->hideOnIndex()
            ->hideWhenCreating()
            ->setColumns(6);
        yield IntegerField::new('getGang2RatingAfterGame', $this->translator->trans('Gang 2 rating after game'))
            ->hideWhenCreating()
            ->setColumns(6);
        yield FormField::addPanel('Credits and loots', $this->translator->trans('Credits and loots'))
            ->hideWhenCreating()
            ->setIcon('fa fa-gem')
            ->collapsible();
        yield NumberField::new('gang1creditsBeforeGame', $this->translator->trans('gang1creditsBeforeGame'))
            ->hideOnIndex()
            ->hideWhenCreating()
            ->setColumns(6)
            ->hideOnIndex();
        yield NumberField::new('gang2creditsBeforeGame', $this->translator->trans('gang2creditsBeforeGame'))
            ->hideOnIndex()
            ->hideWhenCreating()
            ->setColumns(6)
            ->hideOnIndex();
        yield NumberField::new('gang1creditsAfterGame', $this->translator->trans('gang1creditsAfterGame'))
            ->hideWhenCreating()
            ->setColumns(6);
        yield NumberField::new('gang2creditsAfterGame', $this->translator->trans('gang2creditsAfterGame'))
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
        yield FormField::addPanel($this->translator->trans('Winner'))
            ->setIcon('fa fa-trophy')
            ->collapsible();
        yield AssociationField::new('winner', $this->translator->trans('Winner'))
            ->setColumns(6)
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) use ($gangs) {
                    return $er->createQueryBuilder('g')
                        ->where('g.id IN (:ids)')
                        ->setParameter('ids', $gangs);
                },
            ]);
        yield FormField::addPanel($this->translator->trans('Game background and details'))
            ->setIcon('fa fa-book')
            ->collapsible();
        yield TextareaField::new('background', $this->translator->trans('background'))
            ->setColumns(12)
            ->hideOnIndex();
        yield TextareaField::new('summary', $this->translator->trans('summary'))
            ->setColumns(12)
            ->hideWhenCreating()
            ->hideOnIndex()
            ->renderAsHtml();
        yield TextareaField::new('history', $this->translator->trans('history'))
            ->setColumns(12)
            ->hideWhenCreating()
            ->hideOnIndex();
        yield ImageField::new('picture')
            ->setBasePath('uploads/games')
            ->setUploadDir('public/uploads/games')
            ->setFileConstraints(new Image(maxSize: '100000k'))
            ->setTemplatePath('admin/fields/defaultImage.html.twig');
        ;
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
        $downloadGameSheet = Action::new('downloadGameSheetAction', $this->translator->trans('Download'))
            ->setIcon('fa-solid fa-download')
            ->addCssClass('btn btn-light btn-remove-margin')
            ->linkToCrudAction('downloadGameSheet')
        ;

        $exportAction = Action::new($this->translator->trans('CSV export'))
            ->linkToCrudAction('export')
            ->addCssClass('btn btn-success')
            ->setIcon('fa fa-download')
            ->createAsGlobalAction()
        ;

        return $actions
            ->add(Crud::PAGE_INDEX, $customNewGameAction)
            ->add(Crud::PAGE_INDEX, $downloadGameSheet)
            ->add(Crud::PAGE_INDEX, $exportAction)
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

    public function downloadGameSheet(AdminContext $context)
    {
        $entity = $context->getEntity()->getInstance();

        $url = $this->generateUrl('generate_game_table', [
            'id' => $entity->getId()
        ]);

        return $this->redirect($url);
    }

    public function export(AdminContext $context, CsvExporterService $csvExporter)
    {
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->filterFactory->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());
        $queryBuilder = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), $fields, $filters);
        return $csvExporter->createResponseFromQueryBuilder($queryBuilder, $fields, 'games.csv');
    }
}