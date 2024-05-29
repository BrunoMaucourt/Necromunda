<?php

namespace App\Controller\Admin;

use App\EasyAdmin\SkillsField;
use App\Entity\Skills;
use App\Enum\SkillsEnum;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;

class SkillsCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security){
        $this->security = $security;
    }
    public static function getEntityFqcn(): string
    {
        return Skills::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('ganger')
        ;
    }
    public function configureFields(string $pageName): iterable
    {
        yield SkillsField::new('name', 'Name')
            ->formatValue(static function (SkillsEnum $skillsEnum): string {
                return $skillsEnum->enumToString();
            })
            ->setColumns(4);
        yield AssociationField::new('ganger')
            ->setColumns(4)
            ->setFormTypeOptions([
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->join('g.gang', 'gang')
                        ->where('gang.user = :user')
                        ->setParameter('user', $this->getUser());
                },
            ]);
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
                        return self::checkSkillsOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkSkillsOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-file-alt')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkSkillsOfCurrentUser($entity, $security);
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-user')
                    ->displayIf(static function ($entity) use ($security) {
                        return self::checkSkillsOfCurrentUser($entity, $security);
                    });
            })
            ;
    }

    public static function checkSkillsOfCurrentUser(Skills $skills, $security): bool
    {
        if(
            $skills->getGanger()->getGang()->getUser() == $security->getUser()
            || $security->isGranted('ROLE_ADMIN')
        ) {
            return true;
        }

        return false;
    }
}