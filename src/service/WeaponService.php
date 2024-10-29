<?php

namespace App\service;

use App\Entity\Weapon;
use App\Enum\SpecialWeaponEnum;
use App\Enum\WeaponsEnum;
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

    /**
     * @param $weapons
     * @return mixed
     */
    public function getWeaponsWithVariants($weapons): array
    {
        foreach ($weapons as $index => $weapon) {
            if ($weapon->getName() === WeaponsEnum::PLASMA_PISTOL) {
                $plasmaPistolLow = new Weapon();
                $plasmaPistolLow->setName(WeaponsEnum::PLASMA_PISTOL_LOW);
                $plasmaPistolMax = new Weapon();
                $plasmaPistolMax->setName(WeaponsEnum::PLASMA_PISTOL_MAX);
                $weapons[] = $plasmaPistolLow;
                $weapons[] = $plasmaPistolMax;
                unset($weapons[$index]);
            }

            if ($weapon->getName() === WeaponsEnum::PLASMA_GUN) {
                $plasmaGunLow = new Weapon();
                $plasmaGunLow->setName(WeaponsEnum::PLASMA_GUN_LOW);
                $plasmaGunMax = new Weapon();
                $plasmaGunMax->setName(WeaponsEnum::PLASMA_GUN_MAX);
                $weapons[] = $plasmaGunLow;
                $weapons[] = $plasmaGunMax;
                unset($weapons[$index]);
            }

            if ($weapon->getName() === WeaponsEnum::SHOTGUN) {
                $shotgunSolid = new Weapon();
                $shotgunSolid->setName(WeaponsEnum::SHOTGUN_SOLID_SLUG);
                $weapons[] = $shotgunSolid;
                $shotgunScatter = new Weapon();
                $shotgunScatter->setName(WeaponsEnum::SHOTGUN_SCATTER_SHOT);
                $weapons[] = $shotgunScatter;
                unset($weapons[$index]);
            }

            if ($weapon->getName() === WeaponsEnum::MANSTOPPER_SHELLS) {
                $shotgunManstopper = new Weapon();
                $shotgunManstopper->setName(WeaponsEnum::SHOTGUN_MANSTOPPER);
                $weapons[] = $shotgunManstopper;
                unset($weapons[$index]);
            }

            if ($weapon->getName() === WeaponsEnum::HOT_SHOT_SHELLS) {
                $shotgunHotShot = new Weapon();
                $shotgunHotShot->setName(WeaponsEnum::SHOTGUN_HOT_SHOT);
                $weapons[] = $shotgunHotShot;
                unset($weapons[$index]);
            }

            if ($weapon->getName() === WeaponsEnum::BOLT_SHELLS) {
                $shotgunBolt = new Weapon();
                $shotgunBolt->setName(WeaponsEnum::SHOTGUN_BOLT);
                $weapons[] = $shotgunBolt;
                unset($weapons[$index]);
            }

            if ($weapon->getName() === WeaponsEnum::COMBAT_RIFLE) {
                $combatRifleSolid = new Weapon();
                $combatRifleSolid->setName(WeaponsEnum::COMBAT_RIFLE_SOLID_SHELLS);
                $weapons[] = $combatRifleSolid;
                $combatRifleScatter = new Weapon();
                $combatRifleScatter->setName(WeaponsEnum::COMBAT_RIFLE_SCATTER_SHELLS);
                $weapons[] = $combatRifleScatter;
                $combatRifleExecutioner = new Weapon();
                $combatRifleExecutioner->setName(WeaponsEnum::COMBAT_RIFLE_EXECUTIONER_SHELLS);
                $weapons[] = $combatRifleExecutioner;
                unset($weapons[$index]);
            }
        }

        usort($weapons, fn($a, $b) => $a->getName()->enumToString() <=> $b->getName()->enumToString());

        return $weapons;
    }
}