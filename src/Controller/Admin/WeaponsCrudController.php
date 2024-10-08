<?php

namespace App\Controller\Admin;

use App\EasyAdmin\EquipementsField;
use App\EasyAdmin\WeaponsField;
use App\Entity\Ganger;
use App\Entity\Weapon;
use App\Enum\GangerTypeEnum;
use App\Enum\WeaponsEnum;
use App\service\EnumTranslator;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class WeaponsCrudController extends AbstractCrudController
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
        $enumTranslator = $this->enumTranslator;
        $translator = $this->translator;

        yield WeaponsField::new('name', $this->translator->trans('name'))
            ->setEnumTranslator($enumTranslator, $translator)
            ->formatValue(static function (WeaponsEnum $weaponsEnums) use($translator): string {
                if ($translator->getLocale() !== 'en') {
                    $key = 'enum.weapon_' . str_replace(' ', '_', $weaponsEnums->value);
                    $value = $translator->trans($key);
                } else {
                    $value = $weaponsEnums->enumToString();
                }
                return $value;
            })
            ->setColumns(4);
        if (
            $pageName === Crud::PAGE_NEW &&
            $object instanceof Ganger
        ) {
            $ganger = $object;

            yield AssociationField::new('ganger', $this->translator->trans('ganger'))
                ->setColumns(4)
                ->setFormTypeOptions([
                    'query_builder' => function (EntityRepository $er) use ($ganger) {
                        return $er->createQueryBuilder('g')
                            ->where('g.id = :id')
                            ->setParameter('id', $ganger->getId())
                        ;
                    },
                    'data' => $ganger,
                ])
            ;
        } else {
            if ($this->security->isGranted('ROLE_ADMIN')) {
                yield AssociationField::new('ganger', $this->translator->trans('ganger'))
                    ->setColumns(4)
                ;
            } else {
                yield AssociationField::new('ganger', $this->translator->trans('ganger'))
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
            yield IntegerField::new('cost', $this->translator->trans('cost'))
                ->setColumns(4)
                ->setDisabled()
            ;
        }
        yield AssociationField::new('equipements', $this->translator->trans('equipements'))
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
            ])
        ;
        yield BooleanField::new('free', $this->translator->trans('free'))
            ->setColumns(4)
        ;
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