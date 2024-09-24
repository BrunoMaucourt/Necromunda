<?php

namespace App\Controller;

use App\Entity\Advancement;
use App\Entity\Equipement;
use App\Entity\Game;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Injury;
use App\Entity\Loot;
use App\Entity\Skill;
use App\Entity\Territory;
use App\Entity\Weapon;
use App\Enum\GangerTypeEnum;
use App\Enum\WeaponsEnum;
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

    #[Route('/{_locale<%app.supported_locales%>}/admin/generateGangTable/{id}', name: 'generate_gang_table')]
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
        $weapons = $this->weaponService->getWeaponsWithVariants($weapons);

        $referenceValues = [
            GangerTypeEnum::leader->value => [
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
            GangerTypeEnum::heavy->value => [
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
            GangerTypeEnum::ganger->value => [
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
            GangerTypeEnum::juve->value => [
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
            GangerTypeEnum::underhive_scum->value => [
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
            GangerTypeEnum::bounty_hunter->value => [
                'move' => 4,
                'weaponSkill' => 4,
                'ballisticSkill' => 4,
                'strength' => 3,
                'toughness' => 3,
                'wounds' => 2,
                'initiative' => 4,
                'attacks' => 1,
                'leadership' => 8,
            ],
            GangerTypeEnum::ratskin_scout->value => [
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

    #[Route('/{_locale<%app.supported_locales%>}/admin/generateGameTable/{id}', name: 'generate_game_table')]
    public function generateGameReport(int $id): Response
    {
        $gameRepo = $this->entityManager->getRepository(Game::class);
        $game = $gameRepo->find($id);

        if (!$game) {
            throw $this->createNotFoundException('Jeu non trouvé');
        }

        $gang1 = $game->getGang1();
        $gang2 = $game->getGang2();
        $gangers = $gang1->getGangers();
        $advancements = $game->getAdvancements();
        $injuries = $game->getInjuries();
        $territories = $game->getTerritories();
        $loots = $game->getLoots();

        return $this->render('download/gameSheet.html.twig', [
            'game' => $game,
            'gang1' => $gang1,
            'gang2' => $gang2,
            'gangers' => $gangers,
            'advancements' => $advancements,
            'injuries' => $injuries,
            'territories' => $territories,
            'loots' => $loots,
        ]);
    }

    public function sortGangersByType(array $ListOfGangers): array
    {
        $order = [
            GangerTypeEnum::leader->value => 1,
            GangerTypeEnum::heavy->value  => 2,
            GangerTypeEnum::ganger->value => 3,
            GangerTypeEnum::juve->value => 4,
            GangerTypeEnum::underhive_scum->value => 5,
            GangerTypeEnum::bounty_hunter->value => 6,
            GangerTypeEnum::ratskin_scout->value => 7,
        ];

        usort($ListOfGangers, function($a, $b) use ($order) {
            return $order[$a->getType()->enumToString()] <=> $order[$b->getType()->enumToString()];
        });

        return $ListOfGangers;
    }
}