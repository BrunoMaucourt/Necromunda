<?php

namespace App\EventListener;

use App\Entity\Weapon;
use App\service\WeaponService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class WeaponListener
{
    private AdminUrlGenerator $adminUrlGenerator;

    private EntityManagerInterface $entityManager;

    private WeaponService $weaponService;

    public function __construct (
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager,
        WeaponService $weaponService
    )
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
        $this->weaponService = $weaponService;
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof Weapon) {
            return;
        }

        $this->weaponService->removeOrphanWeapon($object);
    }

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof Weapon) {
            return;
        }

        $this->weaponService->removeOrphanWeapon($object);
    }
}