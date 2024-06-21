<?php

namespace App\service;

use App\Entity\Advancement;
use App\Entity\Game;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Injury;
use App\Entity\Loot;
use App\Enum\InjuriesEnum;
use App\Enum\LootEnum;
use App\Enum\TerritoriesEnum;
use Doctrine\ORM\EntityManagerInterface;

class PostGameService
{
    private EntityManagerInterface $entityManager;
    private CheckValueRangeService $checkValueRangeService;

    public function __construct(EntityManagerInterface $entityManager, CheckValueRangeService $checkValueRangeService){
        $this->entityManager = $entityManager;
        $this->checkValueRangeService = $checkValueRangeService;
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
            $summary .= '- ' . $currentTerritory->enumToString() . '<br>';

            $dicesResults = 0;
            $dicesRolls = [];
            for ($numberDice = 0; $numberDice < $numberOfDices; $numberDice++) {
                $diceRoll = mt_rand(1, 6);
                $dicesRolls [] = $diceRoll;
                $dicesResults += $diceRoll;
                $summary .= '  dice ' . $numberDice +1 . ' roll : ' . $diceRoll . '<br>';
            }

            // Check for effects
            if (count($dicesRolls) === 2 && $dicesRolls[0] === $dicesRolls[1]) {
                if ($currentTerritory == TerritoriesEnum::ChemPit) {
                    $summary .= '  double roll, no incone collected and ganger cause fear <br>';
                    $dicesResults = 0;
                } elseif ($currentTerritory == TerritoriesEnum::GamblingDen) {
                    $summary .= '  double roll, no incone collected <br>';
                    $dicesResults = 0;
                } elseif ($currentTerritory == TerritoriesEnum::SporeCave && $dicesRolls[0] === 1) {
                    $summary .= '  double roll 1, ganger is sick and can take part to next battle on 4+ with a D6 <br>';
                }
            }

            if ($currentTerritory == TerritoriesEnum::DrinkingHole) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll == 6) {
                    $summary .= ' +1 or -1 for next scenario table roll <br>';
                }
            }

            if ($currentTerritory == TerritoriesEnum::Settlement) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll == 6) {
                    $summary .= ' recruit for free a juve <br>';
                }
            }

            if ($currentTerritory == TerritoriesEnum::MineralOutcrop) {
                $diceRoll = mt_rand(1, 6);
                if ($diceRoll == 6) {
                    $summary .= '  ' . $diceRoll * 10 . ' credits are added <br>';
                    $gangCreditsGain += $diceRoll * 10;
                }
            }

            // Add credits
            $currentGain = $currentTerritory->getFixedIncome() + $dicesResults * $currentTerritory->getVariableIncomeMultiplicator();
            $gangCreditsGain += $currentGain;
            $summary .= '  ' . $currentGain . ' credits for ' . $currentTerritory->enumToString() . '<br><br>';

            // Save territory
            // ToDo fix bug about persist entity
            //  $game->addTerritory($territory);
        }

        // Calculate giant killer
        if ($game->getWinner() == $currentGang) {
            if ($currentGang->getRating() < $otherGang->getRating()) {
                $gangRatingDifference = $currentGang->getRating() - $otherGang->getRating();
                $summary .= '  -----------------------<br>   Giant killer bonus (gang rating difference = '. abs($gangRatingDifference) .') <br>';
                $bonus = $this->getGiantKillerBonus(abs($gangRatingDifference));
                $gangCreditsGain += $bonus;
                $summary .= '  '. $bonus .' credits bonus added <br><br>';
            } else {
                $summary .= '  -----------------------<br>   No giant killer bonus added because winner higher gang rating <br><br>';
            }
        } else {
            $summary .= '  -----------------------<br>   No giant killer bonus added because the game is loss<br><br>';
        }

        // Calculate Income
        $summary .= '  -----------------------<br>   ' . $gangCreditsGain . ' credits earn for this game <br>';
        $allAliveGangers = $this->entityManager->getRepository(Ganger::class)->findAliveByGang($currentGang->getId());
        $numberOfGanger = count($allAliveGangers);
        $income = $this->getIncomeValue($gangCreditsGain, $numberOfGanger);
        $newCredits = $currentGang->getCredits() + $income;
        $summary .= '  ' . $income . ' credits keep after income ('. $numberOfGanger.' gangers in gang)<br> '.  $newCredits . ' credits at the end of game (Old credits = '. $currentGang->getCredits() . ' + new credits = ' . $income .')<br><br>';

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
        return [
            'gangCreditsGain' => $gangCreditsGain,
            'summary' => $summary,
        ];
    }
}