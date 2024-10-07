<?php

namespace App\service;

use App\Entity\Equipement;
use App\Entity\Gang;
use App\Entity\Item;
use App\Entity\Weapon;

class GangService
{
    /**
     * @param Item $item
     * @return Gang|null
     */
    public function updateGangCredits(Item $item): ?Gang
    {
        if (
            $item instanceof Weapon ||
            $item instanceof Equipement
        ) {
            $ganger = $item->getGanger();
            if ($ganger) {
                $gang = $ganger->getGang();
                if ($gang) {
                    $newGangCredits = $gang->getCredits() - $item->getCost();
                    $gang->setCredits($newGangCredits);
                }

                return $gang;
            }
        }

        return null;
    }
}