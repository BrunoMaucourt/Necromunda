<?php

namespace App\service;

use App\Entity\Gang;
use App\Entity\Weapon;
use App\Enum\SpecialWeaponEnum;
use Doctrine\ORM\EntityManagerInterface;

class WeaponService
{
    private EntityManagerInterface $entityManager;

    public function __construct (
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Weapon $weapon
     * @return void
     */
    public function removeOrphanWeapon(Weapon $weapon): void
    {
        /**
         * $this->entityManager->remove($weapon)
         * don't work here
         */
        $this->entityManager->beginTransaction();

        if ($weapon->getGanger() === null && $weapon->getStash() === null) {
            $sql = 'DELETE FROM weapon WHERE id = :id';
            $stmt = $this->entityManager->getConnection()->prepare($sql);
            $stmt->executeQuery(['id' => $weapon->getId()]);
        }

        $this->entityManager->commit();
    }

    /**
     * @param Weapon $weapon
     * @return Gang|null
     */
    public function updateGangCredits(Weapon $weapon): ?Gang
    {
        $ganger = $weapon->getGanger();
        if ($ganger) {
            $gang = $ganger->getGang();
            if ($gang) {
                $newGangCredits = $gang->getCredits() - $weapon->getCost();
                $gang->setCredits($newGangCredits);
            }

            return $gang;
        }

        return null;
    }

    public function getSpecialForWeapon(array $listOfWeapons): ?array
    {
        $allSpecials = SpecialWeaponEnum::cases();
        $listOfSpecialsToFind = [];
        $specialDescription = [];

        foreach ($listOfWeapons as $weapon) {
            $special = $weapon->getName()->getSpecial();
            if ($special !== " - ") {
                $listOfSpecial = explode(',', $special);
                foreach ($listOfSpecial as $item) {
                    $listOfSpecialsToFind[] = trim($item);
                }
            }
        }

        $listOfSpecialsToFind = array_unique($listOfSpecialsToFind);
        sort($listOfSpecialsToFind);

        foreach ($listOfSpecialsToFind as $special) {
            foreach ($allSpecials as $specialName) {
                if ($special === $specialName->enumToString()) {
                    $specialDescription[$specialName->enumToString()] = $specialName->getDescription();
                }
            }
        }

        return $specialDescription;
    }
}