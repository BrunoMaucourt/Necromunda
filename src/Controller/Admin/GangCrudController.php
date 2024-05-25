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
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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
        yield TextareaField::new('background')
            ->setColumns(4);
        if ($pageName !== Crud::PAGE_NEW) {
            yield NumberField::new('rating')
                ->setColumns(4)
                ->setFormTypeOption('disabled','disabled');
            yield NumberField::new('credits')
                ->setColumns(4);
            yield BooleanField::new('active')
                ->setColumns(4);
            yield AssociationField::new('gangers')
                ->setColumns(4)
                ->renderAsNativeWidget();
            yield AssociationField::new('territories')
                ->setColumns(4);
            yield AssociationField::new('games')
                ->setColumns(4);
            yield AssociationField::new('win')
                ->setColumns(4);
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
                        return self::checkGangOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
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