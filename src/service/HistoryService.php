<?php

namespace App\service;

use App\Entity\Advancement;
use App\Entity\Equipement;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Injury;
use App\Entity\Loot;
use App\Entity\Territory;
use App\Entity\Weapon;
use App\Enum\ScenariosEnum;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\UnitOfWork;

class HistoryService
{
    public function historyMessageFromChanges(array $changes): string
    {
        $historyMessage = "---------------------------------------\n[" . date('Y-m-d H:i:s') . "] Changes:\n";

        foreach ($changes as $field => $change) {
            if ($field === 'history' || $field === 'summary') {
                continue;
            } elseif ($field === 'date') {
                $change[0] = $change[0]->format('Y-m-d');
                $change[1] = $change[1]->format('Y-m-d');
            }

            $correctedFieldName = $this->getCorrectName($field);

            $oldValue = $change[0];
            $newValue = $change[1];
            $historyMessage .= sprintf(
                "Field '%s' changed from '%s' to '%s'\n",
                $correctedFieldName,
                $oldValue,
                $newValue
            );
        }

        return $historyMessage;
    }

    public function historyMessageFromCollections(array $collectionsToCheck, UnitOfWork $unitOfWork): string
    {
        $historyMessage = '';

        foreach ($collectionsToCheck as $collectionName) {
            $correctedCollectionName = $this->getCorrectName($collectionName);

            // Check items add in collections
            foreach ($unitOfWork->getScheduledCollectionUpdates() as $collection) {
                if ($collection->getOwner() instanceof Ganger && $collection->getMapping()['fieldName'] === $collectionName) {
                    foreach ($collection->getInsertDiff() as $item) {
                        $itemName = method_exists($item, '__toString') ? $item->__toString() : get_class($item);
                        if (
                            $item instanceof Weapon ||
                            $item instanceof Equipement
                        ) {
                            $itemName .= " - " . $item->getCost() . " credits";
                        }
                        $historyMessage .= sprintf(
                            "%s added: %s\n",
                            $correctedCollectionName,
                            $itemName
                        );
                    }
                }
            }

            // Check items remove from collections
            foreach ($unitOfWork->getScheduledCollectionUpdates() as $collection) {
                if ($collection->getOwner() instanceof Ganger && $collection->getMapping()['fieldName'] === $collectionName) {
                    foreach ($collection->getDeleteDiff() as $item) {
                        $itemName = method_exists($item, '__toString') ? $item->__toString() : get_class($item);
                        $historyMessage .= sprintf(
                            "%s removed: %s\n",
                            $correctedCollectionName,
                            $itemName
                        );
                    }
                }
            }
        }

        return $historyMessage;
    }

    public function getCorrectName($nameToCorrect): string
    {
        $correctedFieldName = "";

        $fields = [
            // ganger
            "name" => "Name",
            "move" => "Move",
            "weaponSkill" => "Weapon Skill",
            "ballisticSkill" => "Ballistic Skill",
            "strength" => "Strength",
            "toughness" => "Toughness",
            "wounds" => "Wounds",
            "initiative" => "Initiative",
            "attacks" => "Attacks",
            "leadership" => "Leadership",
            "background" => "Background",
            "alive" => "Alive",
            "experience" => "Experience",
            "cost" => "Cost",
            "rating" => "Rating",
            "injuries" => "Injuries",
            "weapons" => "Weapons",
            "equipements" => "Equipements",
            "skills" => "Skills",
            "gang" => "Gang",
            "type" => "Type",
            "advancement" => "Advancement",
            "games" => "Games",
            // game
            "gang1" => "Gang1",
            "gang2" => "Gang2",
            "winner" => "Winner",
            "date" => "Date",
            "gang1RatingBeforeGame" => "Gang1 rating before game",
            "gang1RatingAfterGame" => "Gang1 rating after game",
            "gang2RatingBeforeGame" => "Gang2 rating before game",
            "gang2RatingAfterGame" => "Gang2 rating after game",
            "gang1creditsBeforeGame" => "Gang1 credits before game",
            "gang2creditsBeforeGame" => "Gang2 credits before game",
            "gang1creditsAfterGame" => "Gang1 credits after game",
            "gang2creditsAfterGame" => "Gang2 credits after game",
            "advancements" => "Advancements",
            "gangers" => "Gangers",
            // gang
            "credits" => "Credits",
            "active" => "Active",
            "user" => "User",
            "territories" => "Territories",
            "win" => "Win",
            "house" => "House",
            "loots" => "Loots",
        ];

        foreach ($fields as $fieldName => $fieldValue) {
            if ($nameToCorrect === $fieldName) {
                $correctedFieldName = $fieldValue;
                break;
            }
        }
        return $correctedFieldName;
    }
}