<?php

namespace App\service;

use App\Entity\Gang;
use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

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
}