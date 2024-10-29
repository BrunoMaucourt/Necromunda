<?php

namespace App\service;

use App\Entity\Advancement;
use App\Entity\Game;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Injury;
use App\Entity\Loot;
use App\Enum\GangerTypeEnum;
use App\Enum\InjuriesEnum;
use App\Enum\LootEnum;
use App\Enum\TerritoriesEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostGameService
{
    private CheckValueRangeService $checkValueRangeService;
    private EntityManagerInterface $entityManager;
    private TranslatorInterface $translator;

    public function __construct(
        CheckValueRangeService $checkValueRangeService,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator,
    ){
        $this->checkValueRangeService = $checkValueRangeService;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    public function exploitTerritories(
        Game $game,
        Gang $currentGang,
        Gang $otherGang,
        array $territories
    ): array
    {
        $gangCreditsGain = 0;
        $summary = '';
        foreach ($territories as $territory) {
            /** @var TerritoriesEnum $currentTerritory */
            $currentTerritory = $territory->getName();
            $numberOfDices = $currentTerritory->getVariableIncomeNumberOfDice();
            $summary .= '- ' . $currentTerritory->enumToString() . " \n";

            $dicesResults = 0;
            $dicesRolls = [];
            for ($numberDice = 0; $numberDice < $numberOfDices; $numberDice++) {
                $diceRoll = mt_rand(1, 6);
                $dicesRolls [] = $diceRoll;
                $dicesResults += $diceRoll;
                $summary .= "  dice " . $numberDice +1 . " roll : " . $diceRoll . " \n";
            }

            // Check for effects
            if (count($dicesRolls) === 2 && $dicesRolls[0] === $dicesRolls[1]) {
                if ($currentTerritory == TerritoriesEnum::ChemPit) {
                    $summary .= "  double roll, no incone collected and ganger cause fear \n";
                    $dicesResults = 0;
                } elseif ($currentTerritory == TerritoriesEnum::GamblingDen) {
                    $summary .= "  double roll, no incone collected \n";
                    $dicesResults = 0;
                } elseif ($currentTerritory == TerritoriesEnum::SporeCave && $dicesRolls[0] === 1) {
                    $summary .= "  double roll 1, ganger is sick and can take part to next battle on 4+ with a D6 \n";
                }
            }

            if ($currentTerritory == TerritoriesEnum::DrinkingHole) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll == 6) {
                    $summary .= " dice roll " . $diceRoll .", +1 or -1 for next scenario table roll \n";
                } else {
                    $summary .= " dice roll " . $diceRoll .", no bonus for next scenario table roll \n";
                }
            }

            if ($currentTerritory == TerritoriesEnum::Settlement) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll == 6) {
                    $summary .= " dice roll " . $diceRoll .", recruit a free juve \n";
                } else {
                    $summary .= " dice roll " . $diceRoll .", no free juve \n";
                }
            }

            if ($currentTerritory == TerritoriesEnum::MineralOutcrop) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll == 6) {
                    $summary .= '  ' . $diceRoll * 10 . " credits are added \n";
                    $gangCreditsGain += $diceRoll * 10;
                }
            }

            // Add credits
            $currentGain = $currentTerritory->getFixedIncome() + $dicesResults * $currentTerritory->getVariableIncomeMultiplicator();
            $gangCreditsGain += $currentGain;
            $summary .= "  " . $currentGain . " credits for " . $currentTerritory->enumToString() . " \n \n";
        }

        // Calculate giant killer
        if ($game->getWinner() == $currentGang) {
            if ($currentGang->getRating() < $otherGang->getRating()) {
                $gangRatingDifference = $currentGang->getRating() - $otherGang->getRating();
                $summary .= "  ----------------------- \n Giant killer bonus (gang rating difference = ". abs($gangRatingDifference) .") \n";
                $bonus = $this->getGiantKillerBonus(abs($gangRatingDifference));
                $gangCreditsGain += $bonus;
                $summary .= "  ". $bonus ." credits bonus added as extra income \n \n";
            } else {
                $summary .= "  ----------------------- \n No giant killer bonus added because winner has higher gang rating \n \n";
            }
        } else {
            $summary .= "  ----------------------- \n No giant killer bonus added because the game is loss \n \n";
        }

        // Calculate Income
        $summary .= "  ----------------------- \n" . $gangCreditsGain . " credits earn for this game \n";
        $allAliveGangers = $this->entityManager->getRepository(Ganger::class)->findAliveByGang($currentGang->getId());
        $numberOfGanger = count($allAliveGangers);
        $income = $this->getIncomeValue($gangCreditsGain, $numberOfGanger);
        $newCredits = $currentGang->getCredits() + $income;
        $summary .= $income . " credits keep after income (". $numberOfGanger." gangers in gang) \n ".  $newCredits . " credits at the end of game (old credits = ". $currentGang->getCredits() . ' + new credits = ' . $income .") \n \n";

        $currentGang->setCredits($newCredits);

        return [
            'gangCreditsGain' => $income,
            'summary' => $summary,
        ];
    }

    private function getIncomeValue($income, $numberOfGangers): int
    {
        $incomeRanges = [
            [0, 29],
            [30, 49],
            [50, 79],
            [80, 119],
            [120, 169],
            [170, 229],
            [230, 299],
            [300, 379],
            [380, 459],
            [460, 559],
            [560, PHP_INT_MAX],
        ];

        $modelRanges = [
            [1, 3],
            [4, 6],
            [7, 9],
            [10, 12],
            [13, 15],
            [16, 18],
            [19, PHP_INT_MAX],
        ];

        $values = [
            [15, 10, 5, 0, 0, 0, 0],
            [25, 20, 15, 5, 0, 0, 0],
            [35, 30, 25, 15, 5, 0, 0],
            [50, 45, 40, 30, 20, 5, 0],
            [65, 60, 55, 45, 35, 15, 0],
            [85, 80, 75, 65, 55, 35, 15],
            [105, 100, 95, 85, 75, 55, 35],
            [120, 115, 110, 100, 90, 65, 45],
            [135, 130, 125, 115, 105, 80, 55],
            [145, 140, 135, 125, 115, 90, 65],
            [155, 150, 145, 135, 125, 100, 70],
        ];

        $incomeIndex = 0;
        foreach ($incomeRanges as $index => $range) {
            if ($income >= $range[0] && $income <= $range[1]) {
                $incomeIndex = $index;
                break;
            }
        }

        $modelIndex = 0;
        foreach ($modelRanges as $index => $range) {
            if ($numberOfGangers >= $range[0] && $numberOfGangers <= $range[1]) {
                $modelIndex = $index;
                break;
            }
        }

        return $values[$incomeIndex][$modelIndex];
    }

    private function getGiantKillerBonus($gangRatingDifference) {
        $ratingBonuses = [
            [1, 49, 5],
            [50, 99, 10],
            [100, 149, 15],
            [150, 199, 20],
            [200, 249, 25],
            [250, 499, 50],
            [500, 749, 100],
            [750, 999, 150],
            [1000, 1499, 200],
            [1500, PHP_INT_MAX, 250],
        ];

        foreach ($ratingBonuses as $range) {
            if ($gangRatingDifference >= $range[0] && $gangRatingDifference <= $range[1]) {
                return $range[2];
            }
        }

        return 0;
    }

    /**
     * @param int $ganger
     * @return array
     */
    public function addInjury(Game $game, int $gangerID): array
    {
        /** @var Ganger $currentGanger */
        $currentGanger = $this->entityManager->getRepository(Ganger::class)->find($gangerID);
        $dicesRoll = mt_rand(1, 6) . mt_rand(1, 6);
        $summary = "- " . $currentGanger->getName() . " \n dices roll = " . $dicesRoll . " \n";
        // multiple injuries
        if ($dicesRoll == 16) {
            $rollInjuries = mt_rand(1, 3);
            $numberOfInjuries = $rollInjuries + 1;
            $summary .= " multiple injuries \n " . $numberOfInjuries . " injuries to add (dice roll ". $rollInjuries ." + 1 )\n";
            $injuriesToAdd = 0;

            while ($injuriesToAdd < $numberOfInjuries) {
                $currentDicesRoll = mt_rand(1, 6) . mt_rand(1, 6);
                if (
                    ($currentDicesRoll >= 11 && $currentDicesRoll <= 16) ||
                    ($currentDicesRoll >= 41 && $currentDicesRoll <= 55) ||
                    ($currentDicesRoll >= 61 && $currentDicesRoll <= 63)
                ) {
                    continue;
                } else {
                    $injuriesToAdd++;
                    $dicesRolls[] = $currentDicesRoll;
                    $summary .= " Injury " . $injuriesToAdd . " - dices roll = " . $currentDicesRoll . " \n";
                }
            }
        } else {
            $dicesRolls = [$dicesRoll];
        }

        $injuries = InjuriesEnum::cases();
        foreach ($dicesRolls as $dicesRoll) {
            foreach ($injuries as $injury) {
                // Check infected wound
                if ($dicesRoll == 21) {
                    $numberOfGame = mt_rand(1, 3);
                    $dicesRoll = $dicesRoll . $numberOfGame;
                    $summary .= " Infected wound - dice roll ". $numberOfGame ." games\n";
                }

                if ($this->checkValueRangeService->isBetweenOrEqual($injury->getDicesRange(), $dicesRoll)) {
                    if ($dicesRoll >= 11 && $dicesRoll <= 15) {
                        $currentGanger->setAlive(false);
                    } elseif ($dicesRoll == 22){
                        $newToughness = $currentGanger->getToughness() -1;
                        $currentGanger->setToughness($newToughness);
                    } elseif ($dicesRoll == 23){
                        $newMovement = $currentGanger->getMove() -1;
                        $currentGanger->setMove($newMovement);
                    } elseif ($dicesRoll == 24){
                        $newStrength = $currentGanger->getStrength() -1;
                        $currentGanger->setStrength($newStrength);
                    } elseif ($dicesRoll == 26){
                        $newBallisticSkill = $currentGanger->getBallisticSkill() -1;
                        $currentGanger->setBallisticSkill($newBallisticSkill);
                    } elseif ($dicesRoll == 31){
                        $newInitiative = $currentGanger->getInitiative() -1;
                        $currentGanger->setInitiative($newInitiative);
                    } elseif ($dicesRoll == 32){
                        $newLeadership = $currentGanger->getLeadership() -1;
                        $currentGanger->setLeadership($newLeadership);
                    } elseif ($dicesRoll == 33){
                        $newWeaponskill = $currentGanger->getWeaponskill() -1;
                        $currentGanger->setWeaponskill($newWeaponskill);
                    } elseif ($dicesRoll == 65){
                        $newLeadership = $currentGanger->getLeadership() +1;
                        $currentGanger->setLeadership($newLeadership);
                    } elseif ($dicesRoll == 66){
                        $newExperience = $currentGanger->getExperience() + mt_rand(1, 6) + mt_rand(1, 6);
                        $currentGanger->setExperience($newExperience);
                    }

                    $injuryToAdd = new Injury();
                    $injuryToAdd->setName($injury);
                    $injuryToAdd->setVictim($currentGanger);

                    $summary .= " " . $injury->enumToString() . " is added  \n";
                    $this->entityManager->persist($injuryToAdd);
                    $game->addInjury($injuryToAdd);
                }
            }
        }

        return [
            'injury' => $injuryToAdd,
            'summary' => $summary,
        ];
    }
    public function AddExperience(Game $game, array $gangers): array
    {
        $experienceLevelsForAdvancement = [6, 11, 16, 21, 31, 41, 51, 61, 81, 101, 121, 141, 161, 181, 201, 241, 281, 321, 361, 401];
        $experienceToBecomeGanger = 21;
        $summary = '';
        $advancementsList = [];

        foreach ($gangers as $gangerID => $gangerExperience) {
            /** @var Ganger $currentGanger */
            $currentGanger = $this->entityManager->getRepository(Ganger::class)->find($gangerID);

            /**
             * Add experience
             * Hired gun don't gain experience
             */
            if ($currentGanger->getType()->getType() !== GangerTypeEnum::HIRED_GUNS) {
                $diceRollExperience = mt_rand(1, 6);
                $newExperience = $currentGanger->getExperience() + $diceRollExperience + $gangerExperience;
                $experienceRange = $currentGanger->getExperience() + 1 . "-" . $newExperience;
                $summary .= "- ". $currentGanger->getName() ." (". $currentGanger->getType()->enumToString() .") \nExperience before game = " . $currentGanger->getExperience() ." \nExperience after game = " . $newExperience. " (dice roll : ". $diceRollExperience ." + bonus : ". $gangerExperience .")  \n";
                $currentGanger->setExperience($newExperience);

                // Check for advancement
                foreach ($experienceLevelsForAdvancement as $experienceLevel) {
                    if ($this->checkValueRangeService->isBetweenOrEqual($experienceRange, $experienceLevel)) {
                        $advancementsList[] = $currentGanger;
                        $summary .= "Add advancement - level ". $experienceLevel ."\n";
                        if (
                            $experienceLevel == $experienceToBecomeGanger &&
                            $currentGanger->getType() === GangerTypeEnum::juve
                        ) {
                            $currentGanger->setType(GangerTypeEnum::ganger);
                            $summary .= "Juve become ganger \n";
                        }
                    }
                }

                $summary .= " \n \n";
            }

            $game->addGanger($currentGanger);
        }

        return [
            'advancementsList' => $advancementsList,
            'summary' => $summary,
        ];
    }

    public function AddAdvancement(array $advancementList, Game $game): array
    {
        $summary = '';

        foreach ($advancementList as $advancement) {

            /** @var Ganger $ganger */
            $ganger = $advancement;

            $dice1RollAdvance = mt_rand(1, 6);
            $dice2RollAdvance = mt_rand(1, 6);
            $advancementScore = $dice1RollAdvance + $dice2RollAdvance;
            $summary .= "- " . $ganger->getName() . " (". $ganger->getType()->enumToString() .") \n" . "Advance rolls = ". $advancementScore ." (Dice 1 roll = " . $dice1RollAdvance . " + dice 2 roll = " . $dice2RollAdvance . ") \n";

            $content = "";
            if ($advancementScore == 2 || $advancementScore == 12) {
                $content = "Choose a new skill in any table";
            } elseif ($advancementScore == 3 || $advancementScore == 4 || $advancementScore == 10 || $advancementScore == 11) {
                $content = "Random skill in standard table";
            } elseif ($advancementScore == 5) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll > 3) {
                    $content = "+ 1 attacks";
                    $ganger->setAttacks($ganger->getAttacks() + 1);
                } else {
                    $content = "+ 1 strength";
                    $ganger->setStrength($ganger->getStrength() + 1);
                }
            } elseif ($advancementScore == 6 || $advancementScore == 8) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll > 3) {
                    $content = "+ 1 BS";
                    $ganger->setBallisticSkill($ganger->getBallisticSkill() + 1);
                } else {
                    $content = "+ 1 WS";
                    $ganger->setWeaponSkill($ganger->getStrength() + 1);
                }
            } elseif ($advancementScore == 7) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll > 3) {
                    $content = "+ 1 leadership";
                    $ganger->setLeadership($ganger->getLeadership() + 1);
                } else {
                    $content = "+ 1 initiative";
                    $ganger->setInitiative($ganger->getInitiative() + 1);
                }
            } elseif ($advancementScore == 9) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll > 3) {
                    $content = "+ 1 toughness";
                    $ganger->setToughness($ganger->getToughness() + 1);
                } else {
                    $content = "+ 1 wounds";
                    $ganger->setWounds($ganger->getWounds() + 1);
                }
            }

            $summary .= $content . " \n \n";
            $newAdvancement = new Advancement();
            $newAdvancement->setGanger($ganger);
            $newAdvancement->setContent($content);

            $this->entityManager->persist($newAdvancement);
            $game->addAdvancement($newAdvancement);
        }

        return [
            'summary' => $summary,
        ];
    }

    public function AddLoots(Game $game, Gang $gang): array
    {
        $numberOfLoots = mt_rand(1, 3);
        $summary = "-- Number of loots found " . $numberOfLoots . " \n \n";
        $randomNumbers = [];

        for ($i = 0; $i < $numberOfLoots; $i++) {
            $dicerolls = mt_rand(1, 6) . mt_rand(1, 6);

            $addRoll = [11, 12, 13, 14, 15, 16, 21, 22, 23, 24, 25, 26, 31, 32, 33, 61, 62, 63];
            $addRoll2 = [316,326,336];
            if (in_array($dicerolls, $addRoll)) {
                $dicerolls .= mt_rand(1, 6);
                if (in_array($addRoll2, $addRoll)) {
                    $dicerolls .= mt_rand(1, 6);
                }
            }

            $randomNumbers[] = $dicerolls;
        }

        $loots = LootEnum::cases();

        foreach ($randomNumbers as $randomNumber) {
            $summary .= "- dice roll = ". $randomNumber ." \n";
            foreach ($loots as $loot) {
                if ($this->checkValueRangeService->isBetweenOrEqual($loot->getDicesRange(), (int) $randomNumber)) {
                    $costVariable = '';
                    $costSum = 0;
                    if ($loot == LootEnum::RatskinMap || $loot == LootEnum::MungVase) {
                        $dice = mt_rand(1, 6);
                        $cost = $dice * 10;
                        $summary .= $loot->enumToString() . " - cost = ".$cost." (" . $dice . " x 10) \n \n";
                    } else {
                        for ($dice = 0; $dice < $loot->getVariableDicesNumber(); $dice++) {
                            $addRoll = mt_rand(1, 6);
                            $costSum += $addRoll;
                            $costVariable .= "dice " . $addRoll;
                            if ($dice < $loot->getVariableDicesNumber() - 1) {
                                $costVariable .= " + ";
                            }
                        }

                        $cost = $loot->getFixedCost() + $costSum;
                        $summary .= $loot->enumToString() . " - cost = ".$cost." (".$loot->getFixedCost()." + " . $costVariable . ") \n \n";
                    }

                    $newLoot = new Loot();
                    $newLoot->setName($loot);
                    $newLoot->setCost($cost);
                    $newLoot->setGang($gang);

                    $this->entityManager->persist($newLoot);
                    $game->addLoots($newLoot);
                }
            }
        }

        return [
            'summary' => $summary,
        ];
    }

    public function addTerritoriesToGame(Game $game, array $territories): void
    {
        $connection = $this->entityManager->getConnection();
        $queryBuilder = $connection->createQueryBuilder();
        foreach ($territories as $territory) {
            $queryBuilder
                ->insert('game_territory')
                ->values([
                    'game_id' => ':game_id',
                    'territory_id' => ':territory_id',
                ])
                ->setParameter('game_id', $game->getId())
                ->setParameter('territory_id', $territory->getId())
                ->execute()
            ;
        }
    }

    public function payHiredGuns(array $gangers, Gang $gang): array
    {
        $summary = "";
        $currentGangCredits = $gang->getCredits();
        $creditsToPyaHiredGuns = 0;

        foreach ($gangers as $gangerID => $gangerExperience) {
            /** @var Ganger $currentGanger */
            $currentGanger = $this->entityManager->getRepository(Ganger::class)->find($gangerID);
            if ($currentGanger->getType()->getType() === GangerTypeEnum::HIRED_GUNS) {
                $hiredGunCost = $currentGanger->getCost();
                if ($currentGangCredits - $hiredGunCost > 0) {
                    $creditsToPyaHiredGuns += $hiredGunCost;
                    $summary .= $currentGanger->getName() ." - ". $currentGanger->getType()->enumToString() . " pay (" . $currentGanger->getCost() . " " . $this->translator->trans('credits') . ")\n";
                } else {
                    $summary .= $this->translator->trans('Not enough credit to payed') . $currentGanger->getName() ." - ". $currentGanger->getType()->enumToString() . " (" . $currentGanger->getCost() . " " . $this->translator->trans('credits') . ")\n";
                }
            }
        }

        if ($summary === "") {
            $summary .= $this->translator->trans('No hired gun in the gang') . "\n";
        } else {
            $newCredits = $currentGangCredits - $creditsToPyaHiredGuns;
            $summary .= "New gang credit = " . $newCredits . " (" . $currentGangCredits . " credits before)" . "\n";
            $gang->setCredits($newCredits);
        }

        return [
            'summary' => $summary,
        ];
    }
}