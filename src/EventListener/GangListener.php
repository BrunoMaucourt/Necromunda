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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
class GangListener
{
    private CheckValueRangeService $checkValueRangeService;

    private EntityManagerInterface $entityManager;

    private RequestStack $requestStack;

    public function __construct(
        CheckValueRangeService $checkValueRangeService,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ){
        $this->checkValueRangeService = $checkValueRangeService;
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function prePersist(PrePersistEventArgs $event)
    {
        $flash = $this->requestStack->getSession()->getFlashBag();

        $object = $event->getObject();

        if ($object instanceof Gang && $object->getId() === null) {

            /** @var Gang $object */
            $gang = $object;

            $randomNumbers = [];
            for ($i = 0; $i < 5; $i++) {
                $randomNumbers[] = mt_rand(1, 6) . mt_rand(1, 6);
            }

            $territories = TerritoriesEnum::cases();
            $summary = '';
            foreach ($randomNumbers as $randomNumber) {
                foreach ($territories as $territory) {
                    if ($this->checkValueRangeService->isBetweenOrEqual($territory->getDicesRange(), (int) $randomNumber)) {
                        $newTerritory = new Territory();
                        $newTerritory->setGang($gang);
                        $newTerritory->setName($territory);

                        $this->entityManager->persist($newTerritory);
                        $gang->addTerritory($newTerritory);
                        $summary .= '- ' . $newTerritory->getName()->enumToString() . '<br>';
                    }
                }
            }

            $flash->add(
                'success',
                'New gang : ' . $gang->getName() . '<br><br>' . 'New territories for ' . $gang->getName() . ' : <br><br>' . $summary
            );
        }
    }
}