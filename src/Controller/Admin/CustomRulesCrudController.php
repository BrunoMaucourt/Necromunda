<?php

namespace App\Controller\Admin;

use App\Entity\CustomRules;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class CustomRulesCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return CustomRules::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $existingRule = $this->entityManager->getRepository(CustomRules::class)->findOneBy([]);

        if ($existingRule) {
            return $actions
                ->disable(Action::NEW);
        }

        return $actions;
    }
}