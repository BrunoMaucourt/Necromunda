<?PHP

namespace App\EventListener;

use App\Entity\Game;
use App\Entity\Gang;
use App\service\PostGameService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
class GameListener
{
    private PostGameService $gameService;

    private EntityManagerInterface $entityManager;

    private RequestStack $requestStack;

    public function __construct(
        PostGameService $gameService,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ){
        $this->gameService = $gameService;
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function prePersist(PrePersistEventArgs $event)
    {
        /** @var Gang $object */
        $object = $event->getObject();

        if ($object instanceof Game && $object->getId() === null) {

            // Get data from sessions
            $session = $this->requestStack->getSession();
            $gangRepository = $this->entityManager->getRepository(Gang::class);

            // Add gang
            /** @var Gang $gang1 */
            $gang1 = $gangRepository->find($session->get('gang1'));
            /** @var Gang $gang2 */
            $gang2 = $gangRepository->find($session->get('gang2'));

            $gang1GangersInvolved = $session->get('gang1Injuries');
            $gang2GangersInvolved = $session->get('gang2Injuries');
            $gang1GangersExperiences = $session->get('gang1Experiences');
            $gang2GangersExperiences = $session->get('gang2Experiences');
            $gang1RatingBeforeGame = $gang1->getRating();
            $gang2RatingBeforeGame = $gang2->getRating();
            $gang1CreditsBeforeGame = $gang1->getCredits();
            $gang2CreditsBeforeGame = $gang2->getCredits();

            // Historic
            $summary = '';

            // Exploited territories
            $gang1Territories = $session->get('gang1Territories');
            $summary .= "Territories \n ================ \n Gang 1 \n\n";
            $gang1ExploitedTerritoriesResults = $this->gameService->exploitTerritories($object, $gang1, $gang2, $gang1Territories);
            $summary .= $gang1ExploitedTerritoriesResults['summary'];

            $gang2Territories = $session->get('gang2Territories');
            $summary .= "================ \n Gang 2 \n\n";
            $gang2ExploitedTerritoriesResults = $this->gameService->exploitTerritories($object, $gang2, $gang1, $gang2Territories);
            $summary .= $gang2ExploitedTerritoriesResults['summary'];

            // Add injuries
            $summary .= "Injuries \n ================ \n Gang 1 \n\n";
            foreach ($gang1GangersInvolved as $gangerID => $gangerStatus) {
                if ($gangerStatus === 'involved_injuries') {
                    $result = $this->gameService->addInjury($object, $gangerID);
                    $gang1Injuries = $result['injury'];
                    $summary .= $result['summary'] . "\n";
                }
            }

            $summary .= "================ \n Gang 2 \n\n";
            foreach ($gang2GangersInvolved as $gangerID => $gangerStatus) {
                if ($gangerStatus === 'involved_injuries') {
                    $result = $this->gameService->addInjury($object, $gangerID);
                    $gang2Injuries = $result['injury'];
                    $summary .= $result['summary'] . "\n";
                }
            }

            // Add gangers involved and experience
            $summary .= "Gangers \n ================ \n Gang 1 \n\n";
            $result = $this->gameService->AddExperience($object, $gang1GangersExperiences);
            $summary .= $result['summary'];
            $gang1AdvancementsList = $result['advancementsList'];

            $summary .= "================ \n Gang 2 \n\n";
            $result = $this->gameService->AddExperience($object, $gang2GangersExperiences);
            $summary .= $result['summary'];
            $gang2AdvancementsList = $result['advancementsList'];

            // Add advancements
            $summary .= "Advancements \n ================ \n Gang 1 \n\n";
            $result = $this->gameService->AddAdvancement($gang1AdvancementsList, $object);
            $summary .= $result['summary'] . "\n";

            $summary .= "================ \n Gang 2\n\n";
            $result = $this->gameService->AddAdvancement($gang2AdvancementsList, $object);
            $summary .= $result['summary'] . "\n";

            // Add loots
            $summary .= "Loots\n================\nGang 1 \n\n";
            $result = $this->gameService->AddLoots($object, $gang1);
            $summary .= $result['summary'] . "\n";

            $summary .= "================ \n Gang 2 \n\n";
            $result = $this->gameService->AddLoots($object, $gang2);
            $summary .= $result['summary'] . "\n";

            // Add gang rating
            $gang1RatingAfterGame = $gang1->getRating();
            $gang2RatingAfterGame = $gang2->getRating();

            // Save game
            $object->setGang1($gang1);
            $object->setGang2($gang2);
            $object->setGang1ratingBeforeGame($gang1RatingBeforeGame);
            $object->setGang2ratingBeforeGame($gang2RatingBeforeGame);
            $object->setGang1RatingAfterGame($gang1RatingAfterGame);
            $object->setGang2RatingAfterGame($gang2RatingAfterGame);
            $object->setGang1creditsBeforeGame($gang1CreditsBeforeGame);
            $object->setGang2creditsBeforeGame($gang2CreditsBeforeGame);
            $object->setGang1creditsAfterGame($gang1->getCredits());
            $object->setGang2creditsAfterGame($gang2->getCredits());
            $object->setSummary($summary);

            // Remove sessions
            $session->remove('gang1');
            $session->remove('gang2');
            $session->remove('gang1Injuries');
            $session->remove('gang2Injuries');
            $session->remove('gang1Territories');
            $session->remove('gang2Territories');
            $session->remove('gang1Experiences');
            $session->remove('gang2Experiences');
        }
    }
}