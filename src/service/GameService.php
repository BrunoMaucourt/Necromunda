<?php

namespace App\service;

use App\Repository\GamesRepository;

class GameService
{
    private GamesRepository $gamesRepository;

    public function __construct(
        GamesRepository $gamesRepository
    ){
        $this->gamesRepository = $gamesRepository;
    }

    public function getGangRatingsGraphData(): array
    {
        $games = $this->gamesRepository->getGangRatingsPerDate();

        $gangs = [];
        $lastGangValues = [];
        $ratingsByDate = [];

        foreach ($games as $game) {
            $gangNames = array_keys($gangs);
            if ( !in_array($game['gang1_name'], $gangNames)) {
                $gangs[$game['gang1_name']] = $game['gang1_rating_before'];
            }

            if ( !in_array($game['gang2_name'], $gangNames)) {
                $gangs[$game['gang2_name']] = $game['gang2_rating_before'];
            }
        }

        foreach ($gangs as $gangName => $firstValue) {
            $ratingsByDate[''][$gangName] = $firstValue;
        }

        foreach ($games as $game) {
            $date = $game['date']->format('Y-m-d');
            foreach ($gangs as $gang => $initialValue) {

                if ($game['gang1_name'] == $gang) {
                    $ratingsByDate[$date][$game['gang1_name']] = $game['gang1_rating_after'];
                    $lastGangValues[$gang] = $game['gang1_rating_after'];
                }
                elseif ($game['gang2_name'] == $gang) {
                    $ratingsByDate[$date][$game['gang2_name']] = $game['gang2_rating_after'];
                    $lastGangValues[$gang] = $game['gang2_rating_after'];
                } else {
                    if (!isset($ratingsByDate[$date][$gang])) {
                        $ratingsByDate[$date][$gang] = $lastGangValues[$gang] ?? $initialValue;
                    }
                }
            }
        }

        return $ratingsByDate;
    }
}