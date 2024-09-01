<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserCrudController extends AbstractCrudController
{
    private Security $security;

    private TranslatorInterface $translator;

    public function __construct(
        Security $security,
        TranslatorInterface $translator
    ){
        $this->security = $security;
        $this->translator = $translator;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('username', $this->translator->trans('username'))
            ->setColumns(6);
        yield AssociationField::new('gang', $this->translator->trans('gang'))
            ->setColumns(6);
        if($this->isGranted('ROLE_ADMIN')){
            yield ArrayField::new('roles', $this->translator->trans('roles'))
                ->setColumns(6);
        }

        $entityInstance = $this->getContext()->getEntity()->getInstance();

        if ($entityInstance == $this->security->getUser() || $this->security->isGranted('ROLE_ADMIN')) {
            $passwordField = TextField::new('temporaryPassword')
                ->setLabel($this->translator->trans('Password'))
                ->onlyOnForms()
                ->setColumns(6)
                ->setFormTypeOption('required', false);

            if ($pageName === Crud::PAGE_EDIT) {
                $passwordField->setFormTypeOption('help', $this->translator->trans('Leave blank if you don\'t want to change the password'));
            } else {
                $passwordField->setFormTypeOption('required', true);
            }

            yield $passwordField;
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
                        return $entity == $security->getUser() || $security->isGranted('ROLE_ADMIN');
                    });
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-trash')
                    ->displayIf(static function ($entity) use ($security) {
                        return $entity == $security->getUser() || $security->isGranted('ROLE_ADMIN');
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-file-alt')
                    ->displayIf(static function ($entity) use ($security) {
                        return $entity == $security->getUser() || $security->isGranted('ROLE_ADMIN');
                    });
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                $security = $this->security;
                return $action
                    ->setIcon('fa fa-user')
                    ->displayIf(static function ($entity) use ($security) {
                        return $entity == $security->getUser() || $security->isGranted('ROLE_ADMIN');
                    });
            })
        ;
    }
}