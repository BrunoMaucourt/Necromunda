<?PHP

namespace App\EventListener;


use App\Entity\Gang;
use App\Entity\Territory;
use App\Enum\TerritoriesEnum;
use App\service\CheckValueRangeService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
class GangListener
{
    private CheckValueRangeService $CheckValueRangeService;

    private EntityManagerInterface $entityManager;

    public function __construct(CheckValueRangeService $CheckValueRangeService, EntityManagerInterface $entityManager){
        $this->CheckValueRangeService = $CheckValueRangeService;
        $this->entityManager = $entityManager;
    }

    public function prePersist(PrePersistEventArgs $event)
    {
        /** @var Gang $object */
        $object = $event->getObject();

        if ($object instanceof Gang) {

            $randomNumbers = [];
            for ($i = 0; $i < 5; $i++) {
                $randomNumbers[] = mt_rand(1, 6) . mt_rand(1, 6);
            }

            $territories = TerritoriesEnum::cases();

            foreach ($randomNumbers as $randomNumber) {
                foreach ($territories as $territory) {
                    if ($this->CheckValueRangeService->isBetweenOrEqual($territory->getDicesRange(), (int) $randomNumber)) {
                        $newTerritory = new Territory();
                        $newTerritory->setGang($object);
                        $newTerritory->setName($territory);

                        $this->entityManager->persist($newTerritory);
                        $object->addTerritory($newTerritory);
                    }
                }
            }
        }
    }
}