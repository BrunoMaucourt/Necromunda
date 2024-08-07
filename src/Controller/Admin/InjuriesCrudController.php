<?php

namespace App\Controller\Admin;

use App\EasyAdmin\InjuriesField;
use App\Entity\Ganger;
use App\Entity\Injury;
use App\Enum\InjuriesEnum;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Bundle\SecurityBundle\Security;

class InjuriesCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security){
        $this->security = $security;
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

        yield InjuriesField::new('name', 'Name')
            ->formatValue(static function (InjuriesEnum $injuriesEnum): string {
                return $injuriesEnum->enumToString();
            })
            ->setColumns(4);
        if (
            $pageName === Crud::PAGE_NEW &&
            $object instanceof Ganger
        ) {
            $victim = $object;

            yield AssociationField::new('victim')
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
                yield AssociationField::new('victim')
                    ->setColumns(4)
                ;
            } else {
                yield AssociationField::new('victim')
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
        yield AssociationField::new('author')
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