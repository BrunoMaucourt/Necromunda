<?PHP

namespace App\EventListener;

use App\Entity\Game;
use App\Entity\Gang;
use App\service\HistoryService;
use App\service\PostGameService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class GameListener
{
    private EntityManagerInterface $entityManager;

    private HistoryService $historyService;

    private PostGameService $gameService;

    private RequestStack $requestStack;

    private TranslatorInterface $translator;

    private array $territoriesToAdd = [];

    public function __construct(
        EntityManagerInterface $entityManager,
        HistoryService $historyService,
        PostGameService $gameService,
        RequestStack $requestStack,
        TranslatorInterface $translator
    ){
        $this->entityManager = $entityManager;
        $this->historyService = $historyService;
        $this->gameService = $gameService;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
    }

    public function prePersist(PrePersistEventArgs $event)
    {
        $object = $event->getObject();

        if ($object instanceof Game && $object->getId() === null) {

            /** @var Game $object */
            $game = $object;

            // Get data from sessions
            $session = $this->requestStack->getSession();
            $flash = $session->getFlashBag();
            $gangRepository = $this->entityManager->getRepository(Gang::class);

            // Add gang
            /** @var Gang $gang1 */
            $gang1 = $gangRepository->find($session->get('gang1'));
            /** @var Gang $gang2 */
            $gang2 = $gangRepository->find($session->get('gang2'));

            $scenario = $session->get('scenario');
            $gang1GangersInvolved = $session->get('gang1Injuries');
            $gang2GangersInvolved = $session->get('gang2Injuries');
            $gang1GangersExperiences = $session->get('gang1Experiences');
            $gang2GangersExperiences = $session->get('gang2Experiences');
            $gang1RatingBeforeGame = $gang1->getRating();
            $gang2RatingBeforeGame = $gang2->getRating();
            $gang1CreditsBeforeGame = $gang1->getCredits();
            $gang2CreditsBeforeGame = $gang2->getCredits();

            // Remove loot from previous game
            $this->removeLootFromPreviousGame($gang1->getLoots()->toArray());
            $this->removeLootFromPreviousGame($gang2->getLoots()->toArray());

            // Historic
            $summary = "";

            // Exploited territories
            $gang1Territories = $session->get('gang1Territories');
            $summary .= "Territories \n ================ \n Gang 1 \n\n";
            $gang1ExploitedTerritoriesResults = $this->gameService->exploitTerritories($game, $gang1, $gang2, $gang1Territories);
            $summary .= $gang1ExploitedTerritoriesResults['summary'];
            $this->territoriesToAdd = array_merge($this->territoriesToAdd, $session->get('gang1Territories'));

            $gang2Territories = $session->get('gang2Territories');
            $summary .= "================ \n Gang 2 \n\n";
            $gang2ExploitedTerritoriesResults = $this->gameService->exploitTerritories($game, $gang2, $gang1, $gang2Territories);
            $summary .= $gang2ExploitedTerritoriesResults['summary'];
            $this->territoriesToAdd = array_merge($this->territoriesToAdd, $session->get('gang2Territories'));

            // Add injuries
            $summary .= "Injuries \n ================ \n Gang 1 \n\n";
            foreach ($gang1GangersInvolved as $gangerID => $gangerStatus) {
                if ($gangerStatus === 'involved_injuries') {
                    $result = $this->gameService->addInjury($game, $gangerID);
                    $gang1Injuries = $result['injury'];
                    $summary .= $result['summary'] . "\n";
                }
            }

            $summary .= "================ \n Gang 2 \n\n";
            foreach ($gang2GangersInvolved as $gangerID => $gangerStatus) {
                if ($gangerStatus === 'involved_injuries') {
                    $result = $this->gameService->addInjury($game, $gangerID);
                    $gang2Injuries = $result['injury'];
                    $summary .= $result['summary'] . "\n";
                }
            }

            // Add gangers involved and experience
            $summary .= "Gangers \n ================ \n Gang 1 \n\n";
            $result = $this->gameService->AddExperience($game, $gang1GangersExperiences);
            $summary .= $result['summary'];
            $gang1AdvancementsList = $result['advancementsList'];

            $summary .= "================ \n Gang 2 \n\n";
            $result = $this->gameService->AddExperience($game, $gang2GangersExperiences);
            $summary .= $result['summary'];
            $gang2AdvancementsList = $result['advancementsList'];

            // Add advancements
            $summary .= "Advancements \n ================ \n Gang 1 \n\n";
            $result = $this->gameService->AddAdvancement($gang1AdvancementsList, $game);
            $summary .= $result['summary'] . "\n";

            $summary .= "================ \n Gang 2\n\n";
            $result = $this->gameService->AddAdvancement($gang2AdvancementsList, $game);
            $summary .= $result['summary'] . "\n";

            // Add loots
            $summary .= "Loots\n================\nGang 1 \n\n";
            $result = $this->gameService->AddLoots($game, $gang1);
            $summary .= $result['summary'] . "\n";

            $summary .= "================ \n Gang 2 \n\n";
            $result = $this->gameService->AddLoots($game, $gang2);
            $summary .= $result['summary'] . "\n";

            // Pay hired guns
            $summary .= $this->translator->trans('Hired gun') . "\n ================ \n Gang 1 \n\n";
            $result = $this->gameService->payHiredGuns($gang1GangersExperiences, $gang1);
            $summary .= $result['summary'] . "\n";

            $summary .= "================ \n Gang 2\n\n";
            $result = $this->gameService->payHiredGuns($gang2GangersExperiences, $gang2);
            $summary .= $result['summary'] . "\n";

            // Add gang rating
            $gang1RatingAfterGame = $gang1->getRating();
            $gang2RatingAfterGame = $gang2->getRating();

            // Save game
            $game->setScenario($scenario);
            $game->setGang1($gang1);
            $game->setGang2($gang2);
            $game->setGang1ratingBeforeGame($gang1RatingBeforeGame);
            $game->setGang2ratingBeforeGame($gang2RatingBeforeGame);
            $game->setGang1RatingAfterGame($gang1RatingAfterGame);
            $game->setGang2RatingAfterGame($gang2RatingAfterGame);
            $game->setGang1creditsBeforeGame($gang1CreditsBeforeGame);
            $game->setGang2creditsBeforeGame($gang2CreditsBeforeGame);
            $game->setGang1creditsAfterGame($gang1->getCredits());
            $game->setGang2creditsAfterGame($gang2->getCredits());
            $game->setSummary($summary);

            // Remove sessions
            $session->remove('gang1');
            $session->remove('gang2');
            $session->remove('gang1Injuries');
            $session->remove('gang2Injuries');
            $session->remove('gang1Territories');
            $session->remove('gang2Territories');
            $session->remove('gang1Experiences');
            $session->remove('gang2Experiences');
            // Add flash message
            $flash->add(
                'success',
                $this->translator->trans('New game')
            );
        }
    }

    public function postPersist(PostPersistEventArgs $event)
    {
        $object = $event->getObject();

        if (!$object instanceof Game || empty($this->territoriesToAdd)) {
            return;
        }

        $this->gameService->addTerritoriesToGame($object, $this->territoriesToAdd);

        $this->territoriesToAdd = [];
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Game) {
            return;
        }

        $changes = $args->getEntityChangeSet();
        $uow = $this->entityManager->getUnitOfWork();
        $collectionsToCheck = ['advancements', 'gangers', 'injuries', 'loots', 'territories'];
        $historyMessage = $this->historyService->historyMessageFromChanges($changes);
        $historyMessage .= $this->historyService->historyMessageFromCollections($collectionsToCheck, $uow);

        $currentHistory = $entity->getHistory();
        $newHistory = $currentHistory ? $currentHistory . "\n" . $historyMessage : $historyMessage;
        $entity->setHistory($newHistory);
    }

    /**
     * @param array
     * @return void
     */
    public function removeLootFromPreviousGame(array $gang1PreviousLoots): void
    {
        foreach ($gang1PreviousLoots as $loot) {
            $loot->setActive(false);
        }
    }
}