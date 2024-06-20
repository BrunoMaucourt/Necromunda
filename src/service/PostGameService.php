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
//            $game->addTerritory($territory);
        }

        // Calculate giant killer
        if ($game->getWinner() == $currentGang && $currentGang->getRating() > $otherGang->getRating()) {
            $gangRatingDifference = $currentGang->getRating() - $otherGang->getRating();
            $summary .= '  -----------------------<br>   Giant killer bonus (gang rating difference = '. $gangRatingDifference .') <br>';
            $bonus = $this->getGiantKillerBonus($gangRatingDifference);
            $gangCreditsGain += $bonus;
            $summary .= '  '. $bonus .' credits bonus added <br><br>';
        } else {
            $summary .= '  -----------------------<br>   No giant killer bonus added <br><br>';
        }

        // Calculate Income
        $summary .= '  -----------------------<br>   ' . $gangCreditsGain . ' credits earn for this game <br>';
        $allAliveGangers = $this->entityManager->getRepository(Ganger::class)->findAliveByGang($currentGang->getId());
        $numberOfGanger = count($allAliveGangers);
        $income = $this->getIncomeValue($gangCreditsGain, $numberOfGanger);
        $summary .= '  ' . $income . ' credits keep after income ('. $numberOfGanger.' gangers in gang)<br><br>';

        dump($summary);
        return [
            'gangCreditsGain' => $gangCreditsGain,
            'summary' => $summary,
        ];
    }
}