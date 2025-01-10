<?php

namespace App\Controller;

use App\Entity\CustomRules;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CustomRulesController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/customRules', name: 'custom_rules')]
    public function getCustomRules(): JsonResponse
    {
        $customRulesRepository = $this->entityManager->getRepository(CustomRules::class);
        $customRulesArray = $customRulesRepository->findAll();

        if ($customRulesArray) {
            $customRules = $customRulesArray[0];
        } else {
            $customRules = new CustomRules();
        }

        return $this->json($customRules, 200);
    }
}