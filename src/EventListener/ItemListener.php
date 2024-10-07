<?php

namespace App\EventListener;

use App\Entity\Equipement;
use App\Entity\Item;
use App\Entity\Weapon;
use App\service\GangService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::onFlush, priority: 500, connection: 'default')]
class ItemListener
{
    private AdminUrlGenerator $adminUrlGenerator;
    private EntityManagerInterface $entityManager;
    private GangService $gangService;

    public function __construct (
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager,
        GangService $gangService
    )
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
        $this->gangService = $gangService;
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof Item) {
            return;
        }

        $itemCost = $object->getName()->getFixedCost();
        $object->setCost($itemCost);

        if ( !$object->isFree() ) {
            $this->gangService->updateGangCredits($object);
        }
    }

    public function postPersist(LifecycleEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof Item) {
            return;
        }

        if (
            $object->getName()->getVariableDicesNumber() > 0
            && $object->getCost() === $object->getName()->getFixedCost()
        ) {
            $itemId = $object->getId();

            $equipementRepo = $this->entityManager->getRepository(Equipement::class);
            $itemToProcess = $equipementRepo->findAll();


            $redirectURL = $this->adminUrlGenerator
                ->setRoute('set_item_cost_variable', [
                    'id' => $itemId,
                    'item' => get_class($object)
                ])
                ->generateUrl()
            ;

            $response = new RedirectResponse($redirectURL, 302);
            $response->send();
        }
    }

    public function onFlush(OnFlushEventArgs $event): void
    {
        $em = $event->getObjectManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $object) {
            if (!$object instanceof Item) {
                continue;
            }

            $changeset = $uow->getEntityChangeSet($object);

            if (isset($changeset['cost'])) {
                $beforeUpdate = $changeset['cost'][0];
                $afterUpdate = $changeset['cost'][1];

                // To avoid error with free weapon / equipement
                if ($beforeUpdate ==! 0) {
                    $costUpdate = $afterUpdate - $beforeUpdate;

                    if ($object instanceof Weapon) {
                        if ($object->getGanger()->getGang()) {
                            $gang = $object->getGanger()->getGang();
                        } else {
                            $gang = $object->getStash();
                        }
                    }

                    if ($object instanceof Equipement) {
                        if ($object->getGanger()->getGang()) {
                            $gang = $object->getGanger()->getGang();
                        } else {
                            $gang = $object->getWeapon()->getGanger()->getGang();
                        }
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