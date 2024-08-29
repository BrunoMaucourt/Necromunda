<?PHP

namespace App\EventListener;

use App\Entity\Ganger;
use App\Entity\Skill;
use App\Entity\Weapon;
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

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class GangerListener
{
    private EntityManagerInterface $entityManager;

    private HistoryService $historyService;

    private RequestStack $requestStack;

    public function __construct(
        EntityManagerInterface $entityManager,
        HistoryService $historyService,
        RequestStack $requestStack
    ){
        $this->entityManager = $entityManager;
        $this->historyService = $historyService;
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

            $hiredGunMessage = '';
            $oldDicesResultsHiredGun = [];
            if ($ganger->getType() === GangerTypeEnum::underhive_scum) {
                while ($advancements > 0) {

                    $dice1 = mt_rand(1, 6);
                    $dicesResults = $dice1;
                    if ($dice1 !== 1 ) {
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
                        $dicesResults > 440
                    ) {
                        continue;
                    }
                    $oldDicesResultsHiredGun[] = $dicesResults;

                    switch ($dicesResults) {
                        case 1:
                            $ganger->setBallisticSkill($ganger->getBallisticSkill() + 1);
                            $dicesResultsMessage = "+1 Bs";
                            break;
                        case 21: case 22: case 23:
                            $ganger->setInitiative($ganger->getInitiative() + 1);
                            $dicesResultsMessage = "+1 I";
                            break;
                        case 24: case 25: case 26: case 36:
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
                        case 41: case 42: case 51: case 52: case 61: case 62:
                            $gunfighter = new Skill();
                            $gunfighter->setName(SkillsEnum::ShootingGunfighter);
                            $ganger->addSkill($gunfighter);
                            $dicesResultsMessage = "skill - gun figther (Shooting)";
                            break;
                        case 43: case 53: case 63:
                            $quickWitted = new Skill();
                            $quickWitted->setName(SkillsEnum::AgilityQuickWitted);
                            $ganger->addSkill($quickWitted);
                            $dicesResultsMessage = "skill - quick witted (Agility)";
                            break;
                        case 441: case 451: case 461: case 541: case 551: case 561: case 641: case 651: case 661:
                            $crackShot = new Skill();
                            $crackShot->setName(SkillsEnum::ShootingCrackShot);
                            $ganger->addSkill($crackShot);
                            $dicesResultsMessage = "skill - crack shot (Shooting)";
                            break;
                        case 442: case 452: case 462: case 542: case 552: case 562: case 642: case 652: case 662:
                            $fastShot = new Skill();
                            $fastShot->setName(SkillsEnum::ShootingFastShot);
                            $ganger->addSkill($fastShot);
                            $dicesResultsMessage = "skill - fast shot (Shooting)";
                            break;
                        case 443: case 453: case 463: case 543: case 553: case 563: case 643: case 653: case 663:
                            $hipShooting = new Skill();
                            $hipShooting->setName(SkillsEnum::ShootingHipShooting);
                            $ganger->addSkill($hipShooting);
                            $dicesResultsMessage = "skill - hip shooting (Shooting)";
                            break;
                        case 444: case 454: case 464: case 544: case 554: case 564: case 644: case 654: case 664:
                            $dodge = new Skill();
                            $dodge->setName(SkillsEnum::AgilityDodge);
                            $ganger->addSkill($dodge);
                            $dicesResultsMessage = "skill - dodge (Agility)";
                            break;
                        case 445: case 455: case 465: case 545: case 555: case 565: case 645: case 655: case 665:
                            $rapidFire = new Skill();
                            $rapidFire->setName(SkillsEnum::ShootingRapidFire);
                            $ganger->addSkill($rapidFire);
                            $dicesResultsMessage = "skill - rapid fire (Shooting)";
                            break;
                        case 446: case 456: case 466: case 546: case 556: case 566: case 646: case 656: case 666:
                            $killerReputation = new Skill();
                            $killerReputation->setName(SkillsEnum::FerocityKillerReputation);
                            $ganger->addSkill($killerReputation);
                            $dicesResultsMessage = "skill - killer reputation (Ferocity)";
                            break;
                    }

                    $hiredGunMessage .= "advancement dice result - " . $dicesResults . " : " .$dicesResultsMessage . "\n";
                    $advancements--;
                }
            }

            if ($ganger->getType() === GangerTypeEnum::bounty_hunter) {
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
                        $dicesResults > 31
                    ) {
                        continue;
                    }
                    $oldDicesResultsHiredGun[] = $dicesResults;

                        switch ($dicesResults) {
                            case 11: case 21:
                                $ganger->setWeaponSkill($ganger->getWeaponSkill() + 1);
                                $dicesResultsMessage = "+1 Ws";
                                break;
                            case 12: case 22:
                                $ganger->setBallisticSkill($ganger->getBallisticSkill() + 1);
                                $dicesResultsMessage = "+1 Bs";
                                break;
                            case 13: case 23:
                                $ganger->setInitiative($ganger->getInitiative() + 1);
                                $dicesResultsMessage = "+1 I";
                                break;
                            case 14: case 24:
                                $ganger->setLeadership($ganger->getLeadership() + 1);
                                $dicesResultsMessage = "+1 Le";
                                break;
                            case 151: case 152: case 153: case 251: case 252: case 253:
                                $ganger->setStrength($ganger->getStrength() + 1);
                                $dicesResultsMessage = "+1 S";
                                break;
                            case 154: case 155: case 156: case 254: case 255: case 256:
                                $ganger->setToughness($ganger->getToughness() + 1);
                                $dicesResultsMessage = "+1 T";
                                break;
                            case 161: case 162: case 163: case 261: case 262: case 263:
                                $ganger->setWounds($ganger->getWounds() + 1);
                                $dicesResultsMessage = "+1 W";
                                break;
                            case 164: case 165: case 166: case 264: case 265: case 266:
                                $ganger->setAttacks($ganger->getToughness() + 1);
                                $dicesResultsMessage = "+1 A";
                                break;
                            case 31: case 41: case 51: case 61:
                                $crackShot = new Skill();
                                $crackShot->setName(SkillsEnum::ShootingCrackShot);
                                $ganger->addSkill($crackShot);
                                $dicesResultsMessage = "skill - crack shot (Shooting)";
                                break;
                            case 32: case 42: case 52: case 62:
                                $nervesOfSteel = new Skill();
                                $nervesOfSteel->setName(SkillsEnum::FerocityNervesofSteel);
                                $ganger->addSkill($nervesOfSteel);
                                $dicesResultsMessage = "Skill - nerves of steel (Ferocity)";
                                break;
                            case 33: case 43: case 53: case 63:
                                $marksman = new Skill();
                                $marksman->setName(SkillsEnum::ShootingMarksman);
                                $ganger->addSkill($marksman);
                                $dicesResultsMessage = "skill - Marksman (Shooting)";
                                break;
                            case 341: case 441: case 541: case 641: case 351: case 451: case 551: case 651: case 361: case 461: case 561: case 661:
                                $dodge = new Skill();
                                $dodge->setName(SkillsEnum::AgilityDodge);
                                $ganger->addSkill($dodge);
                                $dicesResultsMessage = "skill - dodge (Agility)";
                                break;
                            case 342: case 442: case 542: case 642: case 352: case 452: case 552: case 652: case 362: case 462: case 562: case 662:
                                $weaponSmith = new Skill();
                                $weaponSmith->setName(SkillsEnum::TechnoWeaponsmith);
                                $ganger->addSkill($weaponSmith);
                                $dicesResultsMessage = "skill - weapon smith (Technology)";
                                break;
                            case 343: case 443: case 543: case 643: case 353: case 453: case 553: case 653: case 363: case 463: case 563: case 663:
                                $trueGrit = new Skill();
                                $trueGrit->setName(SkillsEnum::FerocityTrueGrit);
                                $ganger->addSkill($trueGrit);
                                $dicesResultsMessage = "skill - true grit (Ferocity)";
                                break;
                            case 344: case 444: case 544: case 644: case 354: case 454: case 554: case 654: case 364: case 464: case 564: case 664:
                                $quickWitted = new Skill();
                                $quickWitted->setName(SkillsEnum::AgilityQuickWitted);
                                $ganger->addSkill($quickWitted);
                                $dicesResultsMessage = "skill - quick witted (Agility)";
                                break;
                            case 345: case 445: case 545: case 645: case 355: case 455: case 555: case 655: case 365: case 465: case 565: case 665:
                                $ironWill = new Skill();
                                $ironWill->setName(SkillsEnum::AgilityDodge);
                                $ganger->addSkill($ironWill);
                                $dicesResultsMessage = "skill - iron will (Ferocity)";
                                break;
                            case 346: case 446: case 546: case 646: case 356: case 456: case 556: case 656: case 366: case 466: case 566: case 666:
                                $killerReputation = new Skill();
                                $killerReputation->setName(SkillsEnum::FerocityKillerReputation);
                                $ganger->addSkill($killerReputation);
                                $dicesResultsMessage = "skill - killer reputation (Ferocity)";
                                break;
                        }

                        $hiredGunMessage .= "advancement dice result - " . $dicesResults . " : " .$dicesResultsMessage . "\n";
                        $advancements--;
                    }
                }
            }

            if ($ganger->getType() === GangerTypeEnum::ratskin_scout) {
                while ($advancements > 0) {

                    $advancements--;
                }
            }

            $flashMessage = date("Y/m/d") . ' - ' . "New ganger : " . $ganger->getName() . " (". $ganger->getType()->enumToString() .") : \n \n" . '- experience = '. $experienceMessage ." \n- free knife\n" . $hiredGunMessage;
            $ganger->setHistory( $flashMessage);

            $flash->add(
                'success',
                "New ganger : " . $ganger->getName() . " (". $ganger->getType()->enumToString() .") : <br> <br>" . '- experience = '. $experienceMessage ." <br>- free knife<br>" . $hiredGunMessage
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
        $uow = $this->entityManager->getUnitOfWork();
        $collectionsToCheck = ['games', 'weapons', 'equipements', 'advancements', 'skills', 'injuries'];
        $historyMessage = $this->historyService->historyMessageFromChanges($changes);
        $historyMessage .= $this->historyService->historyMessageFromCollections($collectionsToCheck, $uow);

        $currentHistory = $entity->getHistory();
        $newHistory = $currentHistory ? $currentHistory . "\n" . $historyMessage : $historyMessage;
        $entity->setHistory($newHistory);
    }
}