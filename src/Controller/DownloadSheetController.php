<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Injury;
use App\Entity\Skill;
use App\Entity\Weapon;
use App\service\WeaponService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadSheetController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private WeaponService $weaponService;

    public function __construct(
        EntityManagerInterface $entityManager,
        WeaponService $weaponService
    ){
        $this->entityManager = $entityManager;
        $this->weaponService = $weaponService;
    }

    #[Route('/admin/generateGangTable/{id}', name: 'generate_gang_table')]
    public function generateGangTable(int $id): Response
    {
        $equipmentRepo = $this->entityManager->getRepository(Equipement::class);
        $gangRepo = $this->entityManager->getRepository(Gang::class);
        $gangerRepo = $this->entityManager->getRepository(Ganger::class);
        $injuryRepo = $this->entityManager->getRepository(Injury::class);
        $skillRepo = $this->entityManager->getRepository(Skill::class);
        $weaponRepo = $this->entityManager->getRepository(Weapon::class);

        $equipments = $equipmentRepo->findAllEquipmentsByGang($id);
        $gang = $gangRepo->find($id);
        $gangers = $gangerRepo->findAliveByGang($id);
        $injuries = $injuryRepo->findAllInjuriesByGang($id);
        $skills = $skillRepo->findAllSkillsByGang($id);
        $weapons = $weaponRepo->findAllWeaponsTypeByGang($id);

        $referenceValues = [
            'leader' => [
                'move' => 4,
                'weaponSkill' => 4,
                'ballisticSkill' => 4,
                'strength' => 3,
                'toughness' => 3,
                'wounds' => 1,
                'initiative' => 4,
                'attacks' => 1,
                'leadership' => 8,
            ],
            'heavy' => [
                'move' => 4,
                'weaponSkill' => 3,
                'ballisticSkill' => 3,
                'strength' => 3,
                'toughness' => 3,
                'wounds' => 1,
                'initiative' => 3,
                'attacks' => 1,
                'leadership' => 7,
            ],
            'ganger' => [
                'move' => 4,
                'weaponSkill' => 3,
                'ballisticSkill' => 3,
                'strength' => 3,
                'toughness' => 3,
                'wounds' => 1,
                'initiative' => 3,
                'attacks' => 1,
                'leadership' => 7,
            ],
            'juve' => [
                'move' => 4,
                'weaponSkill' => 2,
                'ballisticSkill' => 2,
                'strength' => 3,
                'toughness' => 3,
                'wounds' => 1,
                'initiative' => 3,
                'attacks' => 1,
                'leadership' => 6,
            ],
            'underhive scum' => [
                'move' => 4,
                'weaponSkill' => 3,
                'ballisticSkill' => 3,
                'strength' => 3,
                'toughness' => 3,
                'wounds' => 1,
                'initiative' => 3,
                'attacks' => 1,
                'leadership' => 7,
            ],
        ];

        $gangers = $this->sortGangersByType($gangers);

        $specials = $this->weaponService->getSpecialForWeapon($weapons);

        return $this->render('download/gangSheet.html.twig', [
            'equipments' => $equipments,
            'gang' => $gang,
            'gangers' => $gangers,
            'injuries' => $injuries,
            'referenceValues' => $referenceValues,
            'specials' => $specials,
            'skills' => $skills,
            'weapons' => $weapons,
        ]);
    }
}
