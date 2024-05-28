<?PHP

namespace App\EventListener;

use App\Entity\Ganger;
use App\Entity\Weapons;
use App\Enum\GangerTypeEnum;
use App\Enum\WeaponsEnum;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
class GangerListener
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    public function prePersist(PrePersistEventArgs $event)
    {
        /** @var Ganger $object */
        $object = $event->getObject();

        // ToDo check number of alive leader and heavy

        if ($object instanceof Ganger) {
            switch ($object->getType()){
                case GangerTypeEnum::leader:
                    $object->setWeaponSkill(4);
                    $object->setBallisticSkill(4);
                    $object->setLeadership(8);
                    $object->setInitiative(4);
                    $object->setCost(120);
                    $object->setExperience(60 + random_int(1, 6));
                    break;
                case GangerTypeEnum::heavy:
                    $object->setWeaponSkill(3);
                    $object->setBallisticSkill(3);
                    $object->setLeadership(7);
                    $object->setInitiative(3);
                    $object->setCost(50);
                    $object->setExperience(60 + random_int(1, 6));
                    break;
                case GangerTypeEnum::ganger:
                    $object->setWeaponSkill(3);
                    $object->setBallisticSkill(3);
                    $object->setLeadership(7);
                    $object->setInitiative(3);
                    $object->setCost(25);
                    $object->setExperience(20 + random_int(1, 6));
                    break;
                case GangerTypeEnum::juve:
                    $object->setWeaponSkill(2);
                    $object->setBallisticSkill(2);
                    $object->setLeadership(6);
                    $object->setInitiative(3);
                    $object->setCost(25);
                    $object->setExperience(0);
                    break;
            }

            $newGangCredits = $ganger->getGang()->getCredits() - $ganger->getCost();
            $ganger->getGang()->setCredits($newGangCredits);
            $ganger->setRating($object->getCost() + $object->getExperience());

            $freeKnife = New Weapons();
            $freeKnife->setName(WeaponsEnum::KNIFE);
            $freeKnife->setGanger($object);
            $freeKnife->setCost(0);
            $this->entityManager->persist($freeKnife);

            $object->addWeapon($freeKnife);
        }
    }
}