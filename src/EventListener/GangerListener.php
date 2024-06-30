<?PHP

namespace App\EventListener;

use App\Entity\Equipement;
use App\Entity\Ganger;
use App\Entity\Weapon;
use App\Enum\GangerTypeEnum;
use App\Enum\WeaponsEnum;
use App\Exception\GangerVerificationFailedException;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class GangerListener
{
    private EntityManagerInterface $entityManager;

    private RequestStack $requestStack;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ){
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }
    public function prePersist(PrePersistEventArgs $event)
    {
        $flash = $this->requestStack->getSession()->getFlashBag();

        $object = $event->getObject();

        if ($object instanceof Ganger && $object->getId() === null) {
            /** @var Ganger $ganger */
            $ganger = $object;
            $gangerGang = $ganger->getGang();

            // Check number of alive leader and heavy
            $gangerRepository = $this->entityManager->getRepository(Ganger::class);

            $numberOfLeader = $gangerRepository->findAliveByType($gangerGang->getId(), 'leader');
            if ($ganger->getType() == GangerTypeEnum::leader) {
                $numberOfLeader += 1;
            }
            if ($numberOfLeader > 1) {
                throw new GangerVerificationFailedException();
            }

            $numberOfHeavy = $gangerRepository->findAliveByType($gangerGang->getId(), 'heavy');
            if ($ganger->getType() == GangerTypeEnum::heavy) {
                $numberOfHeavy += 1;
            }
            if ($numberOfHeavy > 2) {
                throw new GangerVerificationFailedException();
            }

            $diceRollExperience = random_int(1, 6);
            switch ($ganger->getType()){
                case GangerTypeEnum::leader:
                    $ganger->setWeaponSkill(4);
                    $ganger->setBallisticSkill(4);
                    $ganger->setLeadership(8);
                    $ganger->setInitiative(4);
                    $ganger->setCost(120);
                    $newExperience = 60 + $diceRollExperience;
                    $ganger->setExperience($newExperience);
                    $experienceMessage = $newExperience . ' (' . 60 . ' + dice roll ' . $diceRollExperience .')';
                    break;
                case GangerTypeEnum::heavy:
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(3);
                    $ganger->setLeadership(7);
                    $ganger->setInitiative(3);
                    $ganger->setCost(50);
                    $newExperience = 60 + $diceRollExperience;
                    $ganger->setExperience($newExperience);
                    $experienceMessage = $newExperience . ' (' . 60 . ' + dice roll ' . $diceRollExperience .')';
                    break;
                case GangerTypeEnum::ganger:
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(3);
                    $ganger->setLeadership(7);
                    $ganger->setInitiative(3);
                    $ganger->setCost(25);
                    $newExperience = 20 + $diceRollExperience;
                    $ganger->setExperience(60 + $diceRollExperience);
                    $experienceMessage = $newExperience . ' (' . 20 . ' + dice roll ' . $diceRollExperience .')';
                    break;
                case GangerTypeEnum::juve:
                    $ganger->setWeaponSkill(2);
                    $ganger->setBallisticSkill(2);
                    $ganger->setLeadership(6);
                    $ganger->setInitiative(3);
                    $ganger->setCost(25);
                    $ganger->setExperience(0);
                    $experienceMessage = '0';
                    break;
            }

            $newGangCredits = $ganger->getGang()->getCredits() - $ganger->getCost();
            $ganger->getGang()->setCredits($newGangCredits);
            $ganger->setRating($object->getCost() + $object->getExperience());

            $freeKnife = New Weapon();
            $freeKnife->setName(WeaponsEnum::KNIFE);
            $freeKnife->setGanger($object);
            $freeKnife->setCost(0);
            $this->entityManager->persist($freeKnife);

            $object->addWeapon($freeKnife);

            $flash->add(
                'success',
                'New ganger : ' . $ganger->getName() . ' ('. $ganger->getType()->enumToString() .') :<br><br>' . '- experience = '. $experienceMessage .'<br>- free knife<br>'
            );
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Ganger) {
            return;
        }

        $changes = $args->getEntityChangeSet();
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


        $uow = $this->entityManager->getUnitOfWork();
        $collections = ['weapons', 'equipements', 'advancements', 'skills', 'injuries'];

        foreach ($collections as $collectionName) {

            // Check items add in collections
            foreach ($uow->getScheduledCollectionUpdates() as $collection) {
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
            foreach ($uow->getScheduledCollectionUpdates() as $collection) {
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

        $currentHistory = $entity->getHistory();
        $newHistory = $currentHistory ? $currentHistory . "\n" . $historyMessage : $historyMessage;
        $entity->setHistory($newHistory);
    }
}