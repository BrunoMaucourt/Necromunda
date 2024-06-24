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
use Symfony\Component\HttpFoundation\RequestStack;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
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

        // ToDo check number of alive leader and heavy

        if ($object instanceof Ganger && $object->getId() === null) {
            /** @var Ganger $ganger */
            $ganger = $object;
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
}