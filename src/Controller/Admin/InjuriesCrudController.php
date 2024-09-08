<?php

namespace App\Controller\Admin;

use App\EasyAdmin\InjuriesField;
use App\Entity\Ganger;
use App\Entity\Injury;
use App\Enum\InjuriesEnum;
use App\service\EnumTranslator;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class InjuriesCrudController extends AbstractCrudController
{
    private EnumTranslator $enumTranslator;

    private Security $security;

    private TranslatorInterface $translator;

    public function __construct(
        EnumTranslator $enumTranslator,
        Security $security,
        TranslatorInterface $translator
    ){
        $this->enumTranslator = $enumTranslator;
        $this->security = $security;
        $this->translator = $translator;
    }

    public static function getEntityFqcn(): string
    {
        return Injury::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('victim')
        ;
    }
    public function configureFields(string $pageName): iterable
    {
        $object = $this->getContext()->getEntity()->getInstance();
        $enumTranslator = $this->enumTranslator;
        $translator = $this->translator;

        yield InjuriesField::new('name', 'Name')
            ->setEnumTranslator($enumTranslator, $translator)
            ->formatValue(static function (InjuriesEnum $injuriesEnum) use($translator): string {
                if ($translator->getLocale() !== 'en') {
                    $key = 'enum.injuries_' . str_replace(' ', '_', $injuriesEnum->value);
                    $value = $translator->trans($key);
                } else {
                    $value = $injuriesEnum->enumToString();
                }
                return $value;
            })
            ->setColumns(4);
        if (
            $pageName === Crud::PAGE_NEW &&
            $object instanceof Ganger
        ) {
            $victim = $object;

            yield AssociationField::new('victim', $this->translator->trans('victim'))
                ->setColumns(4)
                ->setFormTypeOptions([
                    'query_builder' => function (EntityRepository $er) use ($victim) {
                        return $er->createQueryBuilder('g')
                            ->where('g.id = :id')
                            ->setParameter('id', $victim->getId())
                            ;
                    },
                    'data' => $victim,
                ]);
        } else {
            if ($this->security->isGranted('ROLE_ADMIN')) {
                yield AssociationField::new('victim', $this->translator->trans('victim'))
                    ->setColumns(4)
                ;
            } else {
                yield AssociationField::new('victim', $this->translator->trans('victim'))
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
        yield AssociationField::new('author', $this->translator->trans('author'))
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
                        return self::checkInjuriesOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkInjuriesOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-file-alt')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkInjuriesOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-user')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkInjuriesOfCurrentUser($entity, $security);
                    });
            })
        ;
    }

    public static function checkInjuriesOfCurrentUser(Injury $injury, $security): bool
    {
        if(
            $injury->getVictim()->getGang()->getUser() == $security->getUser()
            || $security->isGranted('ROLE_ADMIN')
        ) {
            return true;
        }

        return false;
    }
}