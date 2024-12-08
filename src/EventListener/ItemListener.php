<?php

namespace App\EventListener;

use App\Entity\Equipement;
use App\Entity\Item;
use App\Entity\Loot;
use App\Entity\Weapon;
use App\Enum\GangerTypeEnum;
use App\service\GangService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::onFlush, priority: 500, connection: 'default')]
class ItemListener
{
    private AdminUrlGenerator $adminUrlGenerator;
    private EntityManagerInterface $entityManager;
    private GangService $gangService;
    private RequestStack $requestStack;

    public function __construct (
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager,
        GangService $gangService,
        RequestStack $requestStack
    )
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
        $this->gangService = $gangService;
        $this->requestStack = $requestStack;
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof Item || $object instanceof Loot) {
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

        if (!$object instanceof Item || $object instanceof Loot) {
            return;
        }

        // Avoid to choose variable cost for enfoncers
        $gangerIsEnfoncer = false;
        if ($object->getGanger()) {
            if ($object->getGanger()->getType()->getType() === GangerTypeEnum::ENFONCERS) {
                $gangerIsEnfoncer = true;
            }
        }

        if (
            $object->getName()->getVariableDicesNumber() > 0 &&
            $object->getCost() === $object->getName()->getFixedCost() &&
            !$gangerIsEnfoncer &&
            !$object->isLoot()
        ) {

            $session = $this->requestStack->getSession();
            $itemsFromSession = $session->get('itemsToProcess', []);
            $alreadyExists = false;

            foreach ($itemsFromSession as $item) {
                if ($item->getId() === $object->getId()) {
                    $alreadyExists = true;
                    break;
                }
            }

            if (!$alreadyExists) {
                $itemsFromSession[] = $object;
            }

            $session->set('itemsToProcess', $itemsFromSession);

            $redirectURL = $this->adminUrlGenerator
                ->setRoute('set_item_cost_variable', [])
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