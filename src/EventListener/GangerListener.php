<?PHP

namespace App\EventListener;

use App\Entity\Equipement;
use App\Entity\Ganger;
use App\Entity\Skill;
use App\Entity\Weapon;
use App\Enum\EquipementsEnum;
use App\Enum\GangerTypeEnum;
use App\Enum\SkillsEnum;
use App\Enum\WeaponsEnum;
use App\Exception\GangerVerificationFailedException;
use App\service\HistoryService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class GangerListener
{
    private EntityManagerInterface $entityManager;

    private HistoryService $historyService;

    private RequestStack $requestStack;

    private TranslatorInterface $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        HistoryService $historyService,
        RequestStack $requestStack,
        TranslatorInterface $translator
    ){
        $this->entityManager = $entityManager;
        $this->historyService = $historyService;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
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
                    $experienceMessage = $newExperience . ' (' . 60 . ' + ' .$this->translator->trans('dice roll') . ' ' . $diceRollExperience .')';
                    break;
                case GangerTypeEnum::heavy:
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(3);
                    $ganger->setLeadership(7);
                    $ganger->setInitiative(3);
                    $ganger->setCost(60);
                    $newExperience = 60 + $diceRollExperience;
                    $ganger->setExperience($newExperience);
                    $experienceMessage = $newExperience . ' (' . 60 . ' + ' .$this->translator->trans('dice roll') . ' ' . $diceRollExperience .')';
                    break;
                case GangerTypeEnum::ganger:
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(3);
                    $ganger->setLeadership(7);
                    $ganger->setInitiative(3);
                    $ganger->setCost(50);
                    $newExperience = 20 + $diceRollExperience;
                    $ganger->setExperience($diceRollExperience);
                    $experienceMessage = $newExperience . ' (' . 20 . ' + ' .$this->translator->trans('dice roll') . ' ' . $diceRollExperience .')';
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
                case GangerTypeEnum::underhive_scum:
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(3);
                    $ganger->setLeadership(7);
                    $ganger->setInitiative(3);
                    $ganger->setCost(15);
                    $ganger->setExperience(0);
                    $experienceMessage = '0';
                    $advancements = 6;
                    break;
                case GangerTypeEnum::bounty_hunter:
                    $ganger->setWeaponSkill(4);
                    $ganger->setBallisticSkill(4);
                    $ganger->setLeadership(8);
                    $ganger->setInitiative(4);
                    $ganger->setWounds(2);
                    $ganger->setCost(35);
                    $ganger->setExperience(0);
                    $experienceMessage = '0';
                    $advancements = 4;
                    break;
                case GangerTypeEnum::ratskin_scout:
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(3);
                    $ganger->setLeadership(7);
                    $ganger->setInitiative(3);
                    $ganger->setCost(15);
                    $ganger->setExperience(0);
                    $experienceMessage = '0';
                    $advancements = 3;
                    break;
                case GangerTypeEnum::sergeant:
                    $ganger->setWeaponSkill(4);
                    $ganger->setBallisticSkill(4);
                    $ganger->setLeadership(8);
                    $ganger->setInitiative(4);
                    $ganger->setCost(0);
                    $ganger->setExperience(0);
                    $experienceMessage = '0';
                    break;
                case GangerTypeEnum::heavy_unit:
                case GangerTypeEnum::special_unit:
                case GangerTypeEnum::canine_unit:
                case GangerTypeEnum::enforcer:
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(3);
                    $ganger->setLeadership(7);
                    $ganger->setInitiative(3);
                    $ganger->setCost(0);
                    $ganger->setExperience(0);
                    $experienceMessage = '0';
                    break;
                case GangerTypeEnum::cyber_mastiff:
                    $ganger->setMove(6);
                    $ganger->setWeaponSkill(3);
                    $ganger->setBallisticSkill(0);
                    $ganger->setStrength(5);
                    $ganger->setToughness(4);
                    $ganger->setInitiative(4);
                    $ganger->setLeadership(0);
                    $ganger->setCost(0);
                    $ganger->setExperience(0);
                    $experienceMessage = '0';
                    break;
            }

            $newGangCredits = $ganger->getGang()->getCredits() - $ganger->getCost();
            $ganger->getGang()->setCredits($newGangCredits);
            $ganger->setRating($object->getCost() + $object->getExperience());

            if ($ganger->getType() ==! GangerTypeEnum::cyber_mastiff) {
                $freeKnife = new Weapon();
                $freeKnife->setName(WeaponsEnum::KNIFE);
                $freeKnife->setGanger($object);
                $freeKnife->setCost(0);
                $freeKnife->setFree(true);
                $this->entityManager->persist($freeKnife);

                $object->addWeapon($freeKnife);
            }

            $gangerSpecificMessage = '';
            $oldDicesResultsHiredGun = [];

            if ($ganger->getType() === GangerTypeEnum::underhive_scum) {
                $gangerSpecificMessage = $this->processUnderhiveScum($advancements, $oldDicesResultsHiredGun, $ganger, $gangerSpecificMessage);
            }

            if ($ganger->getType() === GangerTypeEnum::bounty_hunter) {
                $gangerSpecificMessage = $this->processBountyHunter($advancements, $oldDicesResultsHiredGun, $ganger, $gangerSpecificMessage);
            }

            if ($ganger->getType() === GangerTypeEnum::ratskin_scout) {
                $gangerSpecificMessage = $this->processRatskinScout($advancements, $oldDicesResultsHiredGun, $ganger, $gangerSpecificMessage);
            }

            if (
                $ganger->getType()->getType() === GangerTypeEnum::ENFONCERS &&
                $ganger->getType() !== GangerTypeEnum::cyber_mastiff
            ) {
                $gangerSpecificMessage = $this->processEnfoncers($object, $ganger);
            }

            $flashMessage = date("Y/m/d") . ' - ' . $this->translator->trans('New ganger') . " : " . $ganger->getName() . " (". $ganger->getType()->enumToString() .") : \n \n" . '- ' . $this->translator->trans('experience') . ' = '. $experienceMessage . " \n- " .  $this->translator->trans('free knife'). "\n" . $gangerSpecificMessage;
            $ganger->setHistory( $flashMessage);

            $flashMessage = str_replace("\n", "<br>", $flashMessage);
            $flash->add('success', $flashMessage);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Ganger) {
            return;
        }

        $changes = $args->getEntityChangeSet();
        $uow = $this->entityManager->getUnitOfWork();
        $collectionsToCheck = ['games', 'weapons', 'equipements', 'advancements', 'skills', 'injuries'];
        $historyMessage = $this->historyService->historyMessageFromChanges($changes);
        $historyMessage .= $this->historyService->historyMessageFromCollections($collectionsToCheck, $uow);

        $currentHistory = $entity->getHistory();
        $newHistory = $currentHistory ? $currentHistory . "\n" . $historyMessage : $historyMessage;
        $entity->setHistory($newHistory);
    }

    /**
     * @param int $advancements
     * @param array $oldDicesResultsHiredGun
     * @param Ganger $ganger
     * @param string $hiredGunMessage
     * @return string
     */
    public function processRatskinScout(int $advancements, array $oldDicesResultsHiredGun, Ganger $ganger, string $hiredGunMessage): string
    {
        while ($advancements > 0) {

            $dice1 = mt_rand(1, 6);
            $dicesResults = $dice1;
            $dice2 = mt_rand(1, 6);
            $dicesResults .= $dice2;
            if ($dice1 >= 3 && $dice2 >= 4) {
                $dice3 = mt_rand(1, 6);
                $dicesResults .= $dice3;
            }

            // Check to avoid have 2 time the same skill
            if (
                in_array($dicesResults, $oldDicesResultsHiredGun) &&
                (int)$dicesResults > 30
            ) {
                continue;
            }
            $oldDicesResultsHiredGun[] = $dicesResults;

            $dicesResultsMessage = '';
            switch ($dicesResults) {
                case 11:
                case 12:
                case 13:
                    $ganger->setWeaponSkill($ganger->getWeaponSkill() + 1);
                    $dicesResultsMessage = "+1 Ws";
                    break;
                case 14:
                case 15:
                case 16:
                    $ganger->setInitiative($ganger->getInitiative() + 1);
                    $dicesResultsMessage = "+1 I";
                    break;
                case 21:
                    $ganger->setBallisticSkill($ganger->getBallisticSkill() + 1);
                    $dicesResultsMessage = "+1 Bs";
                    break;
                case 22:
                    $ganger->setStrength($ganger->getStrength() + 1);
                    $dicesResultsMessage = "+1 S";
                    break;
                case 23:
                    $ganger->setToughness($ganger->getToughness() + 1);
                    $dicesResultsMessage = "+1 T";
                    break;
                case 24:
                    $ganger->setWounds($ganger->getWounds() + 1);
                    $dicesResultsMessage = "+1 W";
                    break;
                case 25:
                    $ganger->setAttacks($ganger->getToughness() + 1);
                    $dicesResultsMessage = "+1 A";
                    break;
                case 26:
                    $ganger->setLeadership($ganger->getLeadership() + 1);
                    $dicesResultsMessage = "+1 Le";
                    break;
                case 31:
                case 41:
                case 51:
                case 61:
                    $dodge = new Skill();
                    $dodge->setName(SkillsEnum::AgilityDodge);
                    $ganger->addSkill($dodge);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('leap') . " (" . $this->translator->trans('agility') . ")";
                    break;
                case 32:
                case 42:
                case 52:
                case 62:
                    $leap = new Skill();
                    $leap->setName(SkillsEnum::AgilityLeap);
                    $ganger->addSkill($leap);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('leap') . " (" . $this->translator->trans('agility') . ")";
                    break;
                case 33:
                case 43:
                case 53:
                case 63:
                    $sprint = new Skill();
                    $sprint->setName(SkillsEnum::AgilitySprint);
                    $ganger->addSkill($sprint);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('sprint') . " (" . $this->translator->trans('agility') . ")";
                    break;
                case 341:
                case 441:
                case 541:
                case 641:
                    $catfall = new Skill();
                    $catfall->setName(SkillsEnum::StealthEvade);
                    $ganger->addSkill($catfall);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('catfall') . " (" . $this->translator->trans('agility') . ")";
                    break;
                case 342:
                case 442:
                case 542:
                case 642:
                    $dive = new Skill();
                    $dive->setName(SkillsEnum::StealthDive);
                    $ganger->addSkill($dive);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('dive') . " (" . $this->translator->trans('stealth') . ")";
                    break;
                case 343:
                case 443:
                case 543:
                case 643:
                    $ambush = new Skill();
                    $ambush->setName(SkillsEnum::StealthAmbush);
                    $ganger->addSkill($ambush);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('ambush') . " (" . $this->translator->trans('stealth') . ")";
                    break;
                case 344:
                case 444:
                case 544:
                case 644:
                    $evade = new Skill();
                    $evade->setName(SkillsEnum::StealthEvade);
                    $ganger->addSkill($evade);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('evade') . " (" . $this->translator->trans('stealth') . ")";
                    break;
                case 345:
                case 445:
                case 545:
                case 645:
                    $infiltration = new Skill();
                    $infiltration->setName(SkillsEnum::StealthInfiltration);
                    $ganger->addSkill($infiltration);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('infiltration') . " (" . $this->translator->trans('stealth') . ")";
                    break;
                case 346:
                case 446:
                case 546:
                case 646:
                    $sneakUp = new Skill();
                    $sneakUp->setName(SkillsEnum::StealthSneakUp);
                    $ganger->addSkill($sneakUp);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('sneak up') . " (" . $this->translator->trans('stealth') . ")";
                    break;

            }

            $hiredGunMessage .= $this->translator->trans('advancement dice result') . " - " . $dicesResults . " : " . $dicesResultsMessage . "\n";
            $advancements--;
        }
        return $hiredGunMessage;
    }

    /**
     * @param int $advancements
     * @param array $oldDicesResultsHiredGun
     * @param Ganger $ganger
     * @param string $hiredGunMessage
     * @return string
     */
    public function processBountyHunter(int $advancements, array $oldDicesResultsHiredGun, Ganger $ganger, string $hiredGunMessage): string
    {
        while ($advancements > 0) {

            $dice1 = mt_rand(1, 6);
            $dicesResults = $dice1;
            if ($dice1 === 1 || $dice1 === 2) {
                $dice2 = mt_rand(1, 6);
                $dicesResults .= $dice2;
                if ($dice2 >= 5) {
                    $dice3 = mt_rand(1, 6);
                    $dicesResults .= $dice3;
                }
            } else {
                $dice2 = mt_rand(1, 6);
                $dicesResults .= $dice2;
                if ($dice2 >= 5) {
                    $dice3 = mt_rand(1, 6);
                    $dicesResults .= $dice3;
                }

                // Check to avoid have 2 time the same skill
                if (
                    in_array($dicesResults, $oldDicesResultsHiredGun) &&
                    (int)$dicesResults > 31
                ) {
                    continue;
                }
                $oldDicesResultsHiredGun[] = $dicesResults;

                switch ($dicesResults) {
                    case 11:
                    case 21:
                        $ganger->setWeaponSkill($ganger->getWeaponSkill() + 1);
                        $dicesResultsMessage = "+1 Ws";
                        break;
                    case 12:
                    case 22:
                        $ganger->setBallisticSkill($ganger->getBallisticSkill() + 1);
                        $dicesResultsMessage = "+1 Bs";
                        break;
                    case 13:
                    case 23:
                        $ganger->setInitiative($ganger->getInitiative() + 1);
                        $dicesResultsMessage = "+1 I";
                        break;
                    case 14:
                    case 24:
                        $ganger->setLeadership($ganger->getLeadership() + 1);
                        $dicesResultsMessage = "+1 Le";
                        break;
                    case 151:
                    case 152:
                    case 153:
                    case 251:
                    case 252:
                    case 253:
                        $ganger->setStrength($ganger->getStrength() + 1);
                        $dicesResultsMessage = "+1 S";
                        break;
                    case 154:
                    case 155:
                    case 156:
                    case 254:
                    case 255:
                    case 256:
                        $ganger->setToughness($ganger->getToughness() + 1);
                        $dicesResultsMessage = "+1 T";
                        break;
                    case 161:
                    case 162:
                    case 163:
                    case 261:
                    case 262:
                    case 263:
                        $ganger->setWounds($ganger->getWounds() + 1);
                        $dicesResultsMessage = "+1 W";
                        break;
                    case 164:
                    case 165:
                    case 166:
                    case 264:
                    case 265:
                    case 266:
                        $ganger->setAttacks($ganger->getToughness() + 1);
                        $dicesResultsMessage = "+1 A";
                        break;
                    case 31:
                    case 41:
                    case 51:
                    case 61:
                        $crackShot = new Skill();
                        $crackShot->setName(SkillsEnum::ShootingCrackShot);
                        $ganger->addSkill($crackShot);
                        $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('crack shot') . " (" . $this->translator->trans('shooting') . ")";
                        break;
                    case 32:
                    case 42:
                    case 52:
                    case 62:
                        $nervesOfSteel = new Skill();
                        $nervesOfSteel->setName(SkillsEnum::FerocityNervesofSteel);
                        $ganger->addSkill($nervesOfSteel);
                        $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('nerves of steel') . " (" . $this->translator->trans('ferocity') . ")";
                        break;
                    case 33:
                    case 43:
                    case 53:
                    case 63:
                        $marksman = new Skill();
                        $marksman->setName(SkillsEnum::ShootingMarksman);
                        $ganger->addSkill($marksman);
                        $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('Marksman') . " (" . $this->translator->trans('shooting') . ")";
                        break;
                    case 341:
                    case 441:
                    case 541:
                    case 641:
                    case 351:
                    case 451:
                    case 551:
                    case 651:
                    case 361:
                    case 461:
                    case 561:
                    case 661:
                        $dodge = new Skill();
                        $dodge->setName(SkillsEnum::AgilityDodge);
                        $ganger->addSkill($dodge);
                        $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans(' dodge') . " (" . $this->translator->trans('agility') . ")";
                        break;
                    case 342:
                    case 442:
                    case 542:
                    case 642:
                    case 352:
                    case 452:
                    case 552:
                    case 652:
                    case 362:
                    case 462:
                    case 562:
                    case 662:
                        $weaponSmith = new Skill();
                        $weaponSmith->setName(SkillsEnum::TechnoWeaponsmith);
                        $ganger->addSkill($weaponSmith);
                        $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('weapon smith') . " (" . $this->translator->trans('technology') . ")";
                        break;
                    case 343:
                    case 443:
                    case 543:
                    case 643:
                    case 353:
                    case 453:
                    case 553:
                    case 653:
                    case 363:
                    case 463:
                    case 563:
                    case 663:
                        $trueGrit = new Skill();
                        $trueGrit->setName(SkillsEnum::FerocityTrueGrit);
                        $ganger->addSkill($trueGrit);
                        $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('true grit') . " (" . $this->translator->trans('ferocity') . ")";
                        break;
                    case 344:
                    case 444:
                    case 544:
                    case 644:
                    case 354:
                    case 454:
                    case 554:
                    case 654:
                    case 364:
                    case 464:
                    case 564:
                    case 664:
                        $quickWitted = new Skill();
                        $quickWitted->setName(SkillsEnum::AgilityQuickWitted);
                        $ganger->addSkill($quickWitted);
                        $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('quick witted') . " (" . $this->translator->trans('agility') . ")";
                        break;
                    case 345:
                    case 445:
                    case 545:
                    case 645:
                    case 355:
                    case 455:
                    case 555:
                    case 655:
                    case 365:
                    case 465:
                    case 565:
                    case 665:
                        $ironWill = new Skill();
                        $ironWill->setName(SkillsEnum::AgilityDodge);
                        $ganger->addSkill($ironWill);
                        $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('iron will') . " (" . $this->translator->trans('ferocity') . ")";
                        break;
                    case 346:
                    case 446:
                    case 546:
                    case 646:
                    case 356:
                    case 456:
                    case 556:
                    case 656:
                    case 366:
                    case 466:
                    case 566:
                    case 666:
                        $killerReputation = new Skill();
                        $killerReputation->setName(SkillsEnum::FerocityKillerReputation);
                        $ganger->addSkill($killerReputation);
                        $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('killer reputation') . " (" . $this->translator->trans('ferocity') . ")";
                        break;
                }

                $hiredGunMessage .= $this->translator->trans('advancement dice result') . " - " . $dicesResults . " : " . $dicesResultsMessage . "\n";
                $advancements--;
            }
        }
        return $hiredGunMessage;
    }

    /**
     * @param int $advancements
     * @param array $oldDicesResultsHiredGun
     * @param Ganger $ganger
     * @param string $hiredGunMessage
     * @return string
     */
    public function processUnderhiveScum(int $advancements, array $oldDicesResultsHiredGun, Ganger $ganger, string $hiredGunMessage): string
    {
        while ($advancements > 0) {

            $dice1 = mt_rand(1, 6);
            $dicesResults = $dice1;
            if ($dice1 !== 1) {
                $dice2 = mt_rand(1, 6);
                $dicesResults .= $dice2;
                if ($dice1 > 3 && $dice2 > 3) {
                    $dice3 = mt_rand(1, 6);
                    $dicesResults .= $dice3;
                }
            }

            // Check to avoid have 2 time the same skill
            if (
                in_array($dicesResults, $oldDicesResultsHiredGun) &&
                (int)$dicesResults > 440
            ) {
                continue;
            }
            $oldDicesResultsHiredGun[] = $dicesResults;

            switch ($dicesResults) {
                case 1:
                    $ganger->setBallisticSkill($ganger->getBallisticSkill() + 1);
                    $dicesResultsMessage = "+1 Bs";
                    break;
                case 21:
                case 22:
                case 23:
                    $ganger->setInitiative($ganger->getInitiative() + 1);
                    $dicesResultsMessage = "+1 I";
                    break;
                case 24:
                case 25:
                case 26:
                case 36:
                    $ganger->setLeadership($ganger->getLeadership() + 1);
                    $dicesResultsMessage = "+1 Le";
                    break;
                case 31:
                    $ganger->setWeaponSkill($ganger->getWeaponSkill() + 1);
                    $dicesResultsMessage = "+1 Ws";
                    break;
                case 32:
                    $ganger->setStrength($ganger->getStrength() + 1);
                    $dicesResultsMessage = "+1 S";
                    break;
                case 33:
                    $ganger->setToughness($ganger->getToughness() + 1);
                    $dicesResultsMessage = "+1 T";
                    break;
                case 34:
                    $ganger->setWounds($ganger->getWounds() + 1);
                    $dicesResultsMessage = "+1 W";
                    break;
                case 35:
                    $ganger->setAttacks($ganger->getAttacks() + 1);
                    $dicesResultsMessage = "+1 A";
                    break;
                case 41:
                case 42:
                case 51:
                case 52:
                case 61:
                case 62:
                    $gunfighter = new Skill();
                    $gunfighter->setName(SkillsEnum::ShootingGunfighter);
                    $ganger->addSkill($gunfighter);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('gun figther') . " (" . $this->translator->trans('shooting') . ")";
                    break;
                case 43:
                case 53:
                case 63:
                    $quickWitted = new Skill();
                    $quickWitted->setName(SkillsEnum::AgilityQuickWitted);
                    $ganger->addSkill($quickWitted);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('quick witted ') . " (" . $this->translator->trans('agility') . ")";
                    break;
                case 441:
                case 451:
                case 461:
                case 541:
                case 551:
                case 561:
                case 641:
                case 651:
                case 661:
                    $crackShot = new Skill();
                    $crackShot->setName(SkillsEnum::ShootingCrackShot);
                    $ganger->addSkill($crackShot);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('crack shot') . " (" . $this->translator->trans('shooting') . ")";
                    break;
                case 442:
                case 452:
                case 462:
                case 542:
                case 552:
                case 562:
                case 642:
                case 652:
                case 662:
                    $fastShot = new Skill();
                    $fastShot->setName(SkillsEnum::ShootingFastShot);
                    $ganger->addSkill($fastShot);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('fast shot') . " (" . $this->translator->trans('shooting') . ")";
                    break;
                case 443:
                case 453:
                case 463:
                case 543:
                case 553:
                case 563:
                case 643:
                case 653:
                case 663:
                    $hipShooting = new Skill();
                    $hipShooting->setName(SkillsEnum::ShootingHipShooting);
                    $ganger->addSkill($hipShooting);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('hip shooting') . " (" . $this->translator->trans('shooting') . ")";
                    break;
                case 444:
                case 454:
                case 464:
                case 544:
                case 554:
                case 564:
                case 644:
                case 654:
                case 664:
                    $dodge = new Skill();
                    $dodge->setName(SkillsEnum::AgilityDodge);
                    $ganger->addSkill($dodge);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('dodge') . " (" . $this->translator->trans('agility') . ")";
                    break;
                case 445:
                case 455:
                case 465:
                case 545:
                case 555:
                case 565:
                case 645:
                case 655:
                case 665:
                    $rapidFire = new Skill();
                    $rapidFire->setName(SkillsEnum::ShootingRapidFire);
                    $ganger->addSkill($rapidFire);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('rapid fire') . " (" . $this->translator->trans('shooting') . ")";
                    break;
                case 446:
                case 456:
                case 466:
                case 546:
                case 556:
                case 566:
                case 646:
                case 656:
                case 666:
                    $killerReputation = new Skill();
                    $killerReputation->setName(SkillsEnum::FerocityKillerReputation);
                    $ganger->addSkill($killerReputation);
                    $dicesResultsMessage = $this->translator->trans('skill') . " - " . $this->translator->trans('killer reputation') . " (" . $this->translator->trans('ferocity') . ")";
                    break;
            }

            $hiredGunMessage .= "advancement dice result - " . $dicesResults . " : " . $dicesResultsMessage . "\n";
            $advancements--;
        }
        return $hiredGunMessage;
    }

    /**
     * @param Ganger $object
     * @param Ganger $ganger
     * @return void
     */
    public function processEnfoncers(Ganger $object, Ganger $ganger): string
    {
        $freeGrenadeChokeGas = new Weapon();
        $freeGrenadeChokeGas->setName(WeaponsEnum::CHOKE_GAS);
        $freeGrenadeChokeGas->setGanger($object);
        $freeGrenadeChokeGas->setCost(0);
        $freeGrenadeChokeGas->setFree(true);
        $this->entityManager->persist($freeGrenadeChokeGas);

        $freeGrenadeSmokeGas = new Weapon();
        $freeGrenadeSmokeGas->setName(WeaponsEnum::SMOKE_BOMBS);
        $freeGrenadeSmokeGas->setGanger($object);
        $freeGrenadeSmokeGas->setCost(0);
        $freeGrenadeSmokeGas->setFree(true);
        $this->entityManager->persist($freeGrenadeSmokeGas);

        $freeGrenadePhotonFlare = new Weapon();
        $freeGrenadePhotonFlare->setName(WeaponsEnum::PHOTON_FLARES);
        $freeGrenadePhotonFlare->setGanger($object);
        $freeGrenadePhotonFlare->setCost(0);
        $freeGrenadePhotonFlare->setFree(true);
        $this->entityManager->persist($freeGrenadePhotonFlare);

        $freeFilterPlugs = new Equipement();
        $freeFilterPlugs->setName(EquipementsEnum::FilterPlugs);
        $freeFilterPlugs->setGanger($object);
        $freeFilterPlugs->setCost(0);
        $freeFilterPlugs->setFree(true);
        $this->entityManager->persist($freeFilterPlugs);

        $freePhotoContacts = new Equipement();
        $freePhotoContacts->setName(EquipementsEnum::PhotoContacts);
        $freePhotoContacts->setGanger($object);
        $freePhotoContacts->setCost(0);
        $freePhotoContacts->setFree(true);
        $this->entityManager->persist($freePhotoContacts);

        $freeInfraredGoggles = new Equipement();
        $freeInfraredGoggles->setName(EquipementsEnum::InfraRedGoggles);
        $freeInfraredGoggles->setGanger($object);
        $freeInfraredGoggles->setCost(0);
        $freeInfraredGoggles->setFree(true);
        $this->entityManager->persist($freeInfraredGoggles);

        $armourCarapace = new Equipement();
        $armourCarapace->setName(EquipementsEnum::ExoticArmourCarapace);
        $armourCarapace->setGanger($object);
        $armourCarapace->setCost(0);
        $armourCarapace->setFree(true);
        $this->entityManager->persist($armourCarapace);



        $ironWill = new Skill();
        $ironWill->setName(SkillsEnum::FerocityIronWill);
        $ironWill->setGanger($ganger);
        $this->entityManager->persist($ironWill);

        $nervesOfSteal = new Skill();
        $nervesOfSteal->setName(SkillsEnum::FerocityNervesofSteel);
        $nervesOfSteal->setGanger($ganger);
        $this->entityManager->persist($nervesOfSteal);

        if ($ganger->getType() === GangerTypeEnum::canine_unit) {
            $cyberMastif = new Ganger();
            $cyberMastif->setName('Cyber-mastiff');
            $cyberMastif->setGang($ganger->getGang());
            $cyberMastif->setType(GangerTypeEnum::cyber_mastiff);

            $this->entityManager->persist($cyberMastif);
        }

        return "\n - " . $this->translator->trans('free grenade choke gas') . "\n - " . $this->translator->trans('free grenade smoke gas') . "\n - " . $this->translator->trans('free grenade photon flare') . "\n - " . $this->translator->trans('free filter plugs') . "\n - " . $this->translator->trans('free photo contacts') . "\n\n";
    }
}