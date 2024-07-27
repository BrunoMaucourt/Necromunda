<?php

namespace App\EventListener;

use App\Entity\Weapon;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class WeaponListener
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof Weapon) {
            return;
        }

        $weaponCost = $object->getName()->getWeaponFixedCost();
        $object->setCost($weaponCost);

        if (!$object->isFree()) {
            $this->updateGangCredits($object);
        }

        $this->removeOrphanWeapon($object);
    }

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof Weapon) {
            return;
        }

        $this->updateGangCredits($object);
        $this->removeOrphanWeapon($object);
    }

    /**
     * @param Weapon $weapon
     * @return void
     */
    private function removeOrphanWeapon(Weapon $weapon): void
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

    private function updateGangCredits(Weapon $weapon)
    {
        $ganger = $weapon->getGanger();
        if ($ganger) {
            $gang = $ganger->getGang();
            if ($gang) {
                $newGangCredits = $gang->getCredits() - $weapon->getCost();
                $gang->setCredits($newGangCredits);
            }
        }
    }
}
