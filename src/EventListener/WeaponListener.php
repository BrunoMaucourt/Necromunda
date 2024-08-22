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
use Doctrine\Persistence\Event\LifecycleEventArgs;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::onFlush, priority: 500, connection: 'default')]
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

        $weaponCost = $object->getName()->getWeaponFixedCost();
        $object->setCost($weaponCost);

        if (
            !$object->isFree()
        ) {
            $this->weaponService->updateGangCredits($object);
        }

        $this->weaponService->removeOrphanWeapon($object);
    }

    public function postPersist(LifecycleEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof Weapon) {
            return;
        }

        if (
            $object->getName()->getWeaponVariableCostDiceNumber() > 0
            && $object->getCost() === $object->getName()->getWeaponFixedCost()
        ) {
            $weaponID = $object->getId();

            $redirectURL = $this->adminUrlGenerator
                ->setRoute('set_weapon_cost_variable', ['id' => $weaponID])
                ->generateUrl()
            ;

            $response = new RedirectResponse($redirectURL, 302);
            $response->send();
        }
    }

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof Weapon) {
            return;
        }

        $this->weaponService->removeOrphanWeapon($object);
    }

    public function onFlush(OnFlushEventArgs $event): void
    {
        $em = $event->getObjectManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if (!$entity instanceof Weapon) {
                continue;
            }

            $changeset = $uow->getEntityChangeSet($entity);

            if (isset($changeset['cost'])) {
                $beforeUpdate = $changeset['cost'][0];
                $afterUpdate = $changeset['cost'][1];

                // To avoid error with free weapon
                if ($beforeUpdate ==! 0) {
                    $costUpdate = $afterUpdate - $beforeUpdate;

                    if ($entity->getGanger()->getGang()) {
                        $gang = $entity->getGanger()->getGang();
                    } else {
                        $gang = $entity->getStash();
                    }

                    $gangCreditsBeforeUpdate = $gang->getCredits();
                    $gang->setCredits($gangCreditsBeforeUpdate - $costUpdate);
                    $em->persist($gang);

                    $uow->computeChangeSet($em->getClassMetadata(get_class($gang)), $gang);
                }
            }
        }
    }
}