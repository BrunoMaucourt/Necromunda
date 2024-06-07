<?PHP

namespace App\EventListener;

use App\Entity\Ganger;
use App\Entity\Weapon;
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
            $ganger = $object;
            switch ($ganger->getType()){
                case GangerTypeEnum::leader:
                    $ganger->setWeaponSkill(4);
                    $ganger->setBallisticSkill(4);
                    $ganger->setLeadership(8);
                    $ganger->setInitiative(4);
                    $ganger->setCost(120);
                    $ganger->setExperience(60 + random_int(1, 6));
                    break;
                case GangerTypeEnum::heavy:
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(3);
                    $ganger->setLeadership(7);
                    $ganger->setInitiative(3);
                    $ganger->setCost(50);
                    $ganger->setExperience(60 + random_int(1, 6));
                    break;
                case GangerTypeEnum::ganger:
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(3);
                    $ganger->setLeadership(7);
                    $ganger->setInitiative(3);
                    $ganger->setCost(25);
                    $ganger->setExperience(20 + random_int(1, 6));
                    break;
                case GangerTypeEnum::juve:
                    $ganger->setWeaponSkill(2);
                    $ganger->setBallisticSkill(2);
                    $ganger->setLeadership(6);
                    $ganger->setInitiative(3);
                    $ganger->setCost(25);
                    $ganger->setExperience(0);
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
        }
    }
}