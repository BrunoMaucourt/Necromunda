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
            if ($field === 'history') {
                continue;
            }

            $oldValue = $change[0];
            $newValue = $change[1];
            $historyMessage .= sprintf(
                "Field '%s' changed from '%s' to '%s'\n",
                $field,
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
                            ucfirst($collectionName),
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
                            ucfirst($collectionName),
                            $itemName
                        );
                    }
                }
            }
        }

        return $historyMessage;
    }

}