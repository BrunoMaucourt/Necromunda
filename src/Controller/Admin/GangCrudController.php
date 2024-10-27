<?php

namespace App\Controller\Admin;

use App\EasyAdmin\HouseField;
use App\Entity\CustomRules;
use App\Entity\Gang;
use App\Enum\HouseEnum;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class GangCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    private $security;

    private TranslatorInterface $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security,
        TranslatorInterface $translator,
    )
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->translator = $translator;
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
        $gang = $this->getContext()->getEntity()->getInstance();

        $customRulesRepository = $this->entityManager->getRepository(CustomRules::class);
        $customRulesArray = $customRulesRepository->findAll();
        if ($customRulesArray) {
            $customRules = $customRulesArray[0];
        }

        if ($gang instanceof Gang) {
            $gangId = $gang->getId() ? $gang->getId() : null;
        }

        yield HouseField::new('house', $this->translator->trans('house'))
            ->formatValue(static function (HouseEnum $houseEnum): string {
                return $houseEnum->enumToString();
            })
            ->setColumns(4);
        yield TextField::new('name', $this->translator->trans('name'))
            ->setColumns(4);
        yield AssociationField::new('user', $this->translator->trans('user'))
            ->setColumns(4)
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->where('g.username = :username')
                        ->setParameter('username', $this->getUser()->getUsername());
                },
            ]);
        if ($pageName !== Crud::PAGE_NEW) {
            yield FormField::addPanel('Gang status', $this->translator->trans('Gang status'))
                ->setIcon('fa fa-chart-simple')
                ->collapsible();
            yield IntegerField::new('rating', $this->translator->trans('rating'))
                ->setColumns(4)
                ->setFormTypeOption('disabled','disabled')
                ->setThousandsSeparator(' ');
            yield IntegerField::new('credits', $this->translator->trans('credits'))
                ->setColumns(4)
                ->setThousandsSeparator(' ');
            yield BooleanField::new('active', $this->translator->trans('active'))
                ->setColumns(4)
                ->renderAsSwitch(false);
            yield FormField::addPanel('Gangers and territories', $this->translator->trans('Gangers and territories'))
                ->setIcon('fa fa-user-secret')
                ->collapsible();

            if ($pageName == Crud::PAGE_DETAIL) {
                yield CollectionField::new('gangers', $this->translator->trans('gangers'))
                    ->setColumns(6)
                    ->hideOnIndex();
                yield CollectionField::new('territories', $this->translator->trans('territories'))
                    ->setColumns(6)
                    ->hideOnIndex();
            } else {
                yield CollectionField::new('gangers', $this->translator->trans('gangers'))
                    ->setColumns(12)
                    ->hideOnIndex()
                    ->useEntryCrudForm(GangerCrudController::class);
                yield CollectionField::new('territories', $this->translator->trans('territories'))
                    ->setColumns(12)
                    ->hideOnIndex()
                    ->useEntryCrudForm(TerritoriesCrudController::class);
            }
            yield FormField::addPanel('Weapons stash', $this->translator->trans('Weapons stash'))
                ->setIcon('fa fa-gun')
                ->collapsible();
            yield CollectionField::new('weapons', $this->translator->trans('weapons'))
                ->setColumns(6)
                ->hideOnIndex()
                ->allowAdd(false);
            yield FormField::addPanel('Loots', $this->translator->trans('Loots'))
                ->setIcon('fa fa-gem')
                ->collapsible();
            if ($pageName == Crud::PAGE_DETAIL) {
                yield ArrayField::new('loots', $this->translator->trans('loots'))
                    ->hideWhenCreating()
                    ->hideOnIndex()
                    ->setColumns(12);
            } else {
                yield CollectionField::new('loots', $this->translator->trans('loots'))
                    ->hideWhenCreating()
                    ->hideOnIndex()
                    ->setColumns(12)
                    ->useEntryCrudForm(LootCrudController::class);
            }
            yield FormField::addPanel('Gang fights', $this->translator->trans('Gang fights'))
                ->setIcon('fa fa-dice')
                ->collapsible();
            if ($pageName == Crud::PAGE_DETAIL) {
                yield CollectionField::new('games', $this->translator->trans('games'))
                    ->setColumns(6)
                    ->hideOnIndex();
                yield CollectionField::new('win', $this->translator->trans('win'))
                    ->setColumns(6)
                    ->hideOnIndex();
            } else {
                yield CollectionField::new('games', $this->translator->trans('games'))
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->setFormTypeOption('disabled','disabled');
                yield CollectionField::new('win', $this->translator->trans('win'))
                    ->setColumns(6)
                    ->hideOnIndex()
                    ->setFormTypeOption('disabled','disabled');
            }
        }
        yield FormField::addPanel('Gang background', $this->translator->trans('Gang background'))
            ->setIcon('fa fa-book')
            ->collapsible();
        yield TextareaField::new('background', $this->translator->trans('background'))
            ->setColumns(12)
            ->hideOnIndex();
        yield FormField::addPanel('Gang history', $this->translator->trans('Gang history'))
            ->setIcon('fa-solid fa-clock-rotate-left')
            ->hideWhenCreating()
            ->collapsible();
        yield TextareaField::new('history', $this->translator->trans('history'))
            ->setColumns(12)
            ->hideWhenCreating()
            ->hideOnIndex();
        if ($customRulesArray) {
            if ($customRules->isDestinyScore()) {
                yield FormField::addPanel('Custom rules', $this->translator->trans('Custom rules'))
                    ->setIcon('fa-solid fa-screwdriver-wrench')
                    ->hideWhenCreating()
                    ->collapsible();
                yield IntegerField::new('destinyScore', $this->translator->trans('destiny score'))
                    ->setColumns(12)
                    ->hideWhenCreating();
            }
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        $downloadGangSheet = Action::new('downloadGangSheetAction', $this->translator->trans('Download'))
            ->setIcon('fa-solid fa-download')
            ->addCssClass('btn btn-light btn-remove-margin')
            ->linkToCrudAction('downloadGangSheet')
       ;

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye')
                    ->setCssClass('btn btn-light btn-remove-margin');
            })
            ->add(Crud::PAGE_INDEX, $downloadGangSheet)
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

    public function downloadGangSheet(AdminContext $context)
    {
        $entity = $context->getEntity()->getInstance();

        $url = $this->generateUrl('generate_gang_table', [
            'id' => $entity->getId()
        ]);

        return $this->redirect($url);
    }
}