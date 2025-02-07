<?php

namespace App\Controller\Admin;

use App\EasyAdmin\GangerTypeField;
use App\Entity\CustomRules;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Enum\GangerTypeEnum;
use App\service\CsvExporterService;
use App\service\EnumTranslator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use \Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Contracts\Translation\TranslatorInterface;

class GangerCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    private EnumTranslator $enumTranslator;

    private FilterFactory $filterFactory;

    private Security $security;

    private TranslatorInterface $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        EnumTranslator $enumTranslator,
        FilterFactory $filterFactory,
        Security $security,
        TranslatorInterface $translator
    )
    {
        $this->entityManager = $entityManager;
        $this->enumTranslator = $enumTranslator;
        $this->filterFactory = $filterFactory;
        $this->security = $security;
        $this->translator = $translator;
    }
    public static function getEntityFqcn(): string
    {
        return Ganger::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
        ;
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
        $context = $this->getContext()->getEntity()->getInstance();
        $translator = $this->translator;
        $enumTranslator = $this->enumTranslator;

        $customRulesRepository = $this->entityManager->getRepository(CustomRules::class);
        $customRulesArray = $customRulesRepository->findAll();
        if ($customRulesArray) {
            $customRules = $customRulesArray[0];
        }

        if ($pageName === Crud::PAGE_NEW) {
            yield TextField::new('name', $this->translator->trans('name'))
                ->setColumns(6)
            ;
            yield AssociationField::new('gang', $this->translator->trans('gang'))
                ->setColumns(6)
                ->setFormTypeOptions([
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                            ->where('g.user = :user')
                            ->setParameter('user', $this->getUser());
                    },
                ])
            ;
            yield GangerTypeField::new('type', $this->translator->trans('Ganger type'))
                ->setEnumTranslator($enumTranslator, $translator)
                ->formatValue(static function (GangerTypeEnum $gangerType) use($translator): string {
                    if ($translator->getLocale() !== 'en') {
                        $value = $translator->trans($gangerType->value);
                    } else {
                        $value = $gangerType->enumToString();
                    }
                    return $value;
                })
                ->setColumns(6)
            ;
            yield BooleanField::new('free', $this->translator->trans('free'))
                ->setColumns(4)
            ;
        } else {
            yield AssociationField::new('gang', $this->translator->trans('gang'))
                ->setColumns(6)
                ->onlyOnIndex();
            yield GangerTypeField::new('type', $this->translator->trans('Ganger type'))
                ->setEnumTranslator($enumTranslator, $translator)
                ->formatValue(static function (GangerTypeEnum $gangerType) use($translator): string {
                    if ($translator->getLocale() !== 'en') {
                        $value = $translator->trans($gangerType->value);
                    } else {
                       $value = $gangerType->enumToString();
                    }
                    return $value;
                })
                ->setColumns(3);
            yield TextField::new('name', $this->translator->trans('name'))
                ->setColumns(6)
                ->hideOnIndex();
            yield TextField::new('name', $this->translator->trans('name'))
                ->onlyOnIndex()
                ->setTemplatePath('admin/fields/nameAsLink.html.twig');
            yield BooleanField::new('alive', $this->translator->trans('alive'))
                ->setColumns(3)
                ->renderAsSwitch(false);
            yield FormField::addPanel('Characteristics', $this->translator->trans('Characteristics'))
                ->setIcon('fa fa-list-ol')
                ->collapsible();
            yield IntegerField::new('move')
                ->setLabel('M')
                ->setHelp('Move')
                ->setFormTypeOption('attr', ['min' => 0, 'max' => 6])
                ->setFormTypeOption('constraints', [new Range(['min' => 0, 'max' => 6])])
                ->setColumns(3);
            yield IntegerField::new('weaponSkill')
                ->setLabel('WS')
                ->setHelp('Weapon Skill')
                ->setFormTypeOption('attr', ['min' => 0, 'max' => 6])
                ->setFormTypeOption('constraints', [new Range(['min' => 0, 'max' => 6])])
                ->setColumns(3);
            yield IntegerField::new('ballisticSkill')
                ->setLabel('BS')
                ->setHelp('Ballistic Skill')
                ->setFormTypeOption('attr', ['min' => 0, 'max' => 6])
                ->setFormTypeOption('constraints', [new Range(['min' => 0, 'max' => 6])])
                ->setColumns(3);
            yield IntegerField::new('strength')
                ->setLabel('S')
                ->setHelp('Strength')
                ->setFormTypeOption('attr', ['min' => 0, 'max' => 5])
                ->setFormTypeOption('constraints', [new Range(['min' => 0, 'max' => 5])])
                ->setColumns(3);
            yield IntegerField::new('toughness')
                ->setLabel('T')
                ->setHelp('Toughness')
                ->setFormTypeOption('attr', ['min' => 0, 'max' => 4])
                ->setFormTypeOption('constraints', [new Range(['min' => 0, 'max' => 4])])
                ->setColumns(3);
            yield IntegerField::new('wounds')
                ->setLabel('W')
                ->setHelp('Wounds')
                ->setFormTypeOption('attr', ['min' => 0, 'max' => 3])
                ->setFormTypeOption('constraints', [new Range(['min' => 0, 'max' => 3])])
                ->setColumns(3);
            yield IntegerField::new('initiative')
                ->setLabel('I')
                ->setHelp('Initiative')
                ->setFormTypeOption('attr', ['min' => 0, 'max' => 6])
                ->setFormTypeOption('constraints', [new Range(['min' => 0, 'max' => 6])])
                ->setColumns(3);
            yield IntegerField::new('attacks')
                ->setLabel('A')
                ->setHelp('Attacks')
                ->setFormTypeOption('attr', ['min' => 0, 'max' => 3])
                ->setFormTypeOption('constraints', [new Range(['min' => 0, 'max' => 3])])
                ->setColumns(3);
            yield IntegerField::new('leadership')
                ->setLabel('Ld')
                ->setHelp('Leadership')
                ->setFormTypeOption('attr', ['min' => 0, 'max' => 9])
                ->setFormTypeOption('constraints', [new Range(['min' => 0, 'max' => 9])])
                ->setColumns(3);
            yield IntegerField::new('experience', $this->translator->trans('experience'))
                ->setLabel('Xp')
                ->setHelp('Experience')
                ->setColumns(3);
            yield IntegerField::new('rating', $this->translator->trans('rating'))
                ->setColumns(3);
            yield FormField::addPanel('Injuries and skills', $this->translator->trans('Injuries and skills'))
                ->setIcon('fa fa-info')
                ->collapsible();
            if ($pageName == Crud::PAGE_DETAIL) {
                yield CollectionField::new('injuries', $this->translator->trans('injuries'))
                    ->setColumns(6)
                    ->hideOnIndex();
                yield CollectionField::new('skills', $this->translator->trans('skills'))
                    ->setColumns(6)
                    ->hideOnIndex();
            } else {
                yield CollectionField::new('injuries', $this->translator->trans('injuries'))
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->useEntryCrudForm(InjuriesCrudController::class)
                    ->addCssClass('crudResponsive');
                yield CollectionField::new('skills', $this->translator->trans('skills'))
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->useEntryCrudForm(SkillsCrudController::class)
                    ->addCssClass('crudResponsive');
            }
            yield FormField::addPanel('Weapons and equipements', $this->translator->trans('Weapons and equipements'))
                ->setIcon('fa fa-gun')
                ->collapsible();
            if ($pageName == Crud::PAGE_DETAIL) {
                yield CollectionField::new('weapons', $this->translator->trans('weapons'))
                    ->setColumns(6)
                    ->hideOnIndex();
                yield CollectionField::new('equipements', $this->translator->trans('equipements'))
                    ->setColumns(6)
                    ->hideOnIndex();
            } else {
                yield CollectionField::new('weapons', $this->translator->trans('weapons'))
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->useEntryCrudForm(WeaponsCrudController::class)
                    ->addCssClass('crudResponsive');
                yield CollectionField::new('equipements', $this->translator->trans('equipements'))
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->useEntryCrudForm(EquipementsCrudController::class)
                    ->addCssClass('crudResponsive');
            }
            yield FormField::addPanel('Advancements', $this->translator->trans('Advancements'))
                ->setIcon('fa fa-gun')
                ->collapsible();
            yield CollectionField::new('advancement', $this->translator->trans('advancement'))
                ->setColumns(6)
                ->hideOnIndex()
                ->addCssClass('crudResponsive');
            yield FormField::addPanel('Ganger background', $this->translator->trans('Ganger background'))
                ->setIcon('fa fa-book')
                ->collapsible();
            yield TextareaField::new('background', $this->translator->trans('background'))
                ->setColumns(12)
                ->hideOnIndex();
            yield FormField::addPanel('Ganger history', $this->translator->trans('Ganger history'))
                ->setIcon('fa-solid fa-clock-rotate-left')
                ->collapsible();
            yield TextareaField::new('history', $this->translator->trans('history'))
                ->setColumns(12)
                ->hideOnIndex();
            yield ImageField::new('picture')
                ->setBasePath('uploads/gangers')
                ->setUploadDir('public/uploads/gangers')
                ->setFileConstraints(new Image(maxSize: '100000k'))
                ->setTemplatePath('admin/fields/defaultImage.html.twig');
            ;
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        $exportAction = Action::new($this->translator->trans('CSV export'))
            ->linkToCrudAction('export')
            ->addCssClass('btn btn-success')
            ->setIcon('fa fa-download')
            ->createAsGlobalAction()
        ;

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $exportAction)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye')
                   ->setCssClass('btn btn-light btn-remove-margin')
                ;
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-pen-to-square')
                    ->setCssClass('btn btn-light btn-remove-margin')
                    ->displayIf(static function ($entity) use ($security) {
                    return self::checkGangsOfCurrentUser($entity, $security);
                });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->addCssClass('btn btn-light btn-remove-margin')
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
                    ->setIcon('fa fa-trash')
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

    public function export(AdminContext $context, CsvExporterService $csvExporter)
    {
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->filterFactory->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());
        $queryBuilder = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), $fields, $filters);
        return $csvExporter->createResponseFromQueryBuilder($queryBuilder, $fields, 'gangers.csv');
    }
}