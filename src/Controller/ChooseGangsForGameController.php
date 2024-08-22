<?php

namespace App\Controller;

use App\Controller\Admin\GamesCrudController;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Enum\GangerTypeEnum;
use App\Form\ChooseGangersForm;
use App\Form\ChooseGangsForm;
use App\Form\ChooseExperienceForm;
use App\Form\ChooseScenarioForm;
use App\Form\ChooseTerritoriesForm;
use App\Repository\GangerRepository;
use App\service\CheckValueRangeService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChooseGangsForGameController extends AbstractController
{
    private AdminUrlGenerator $adminUrlGenerator;
    private CheckValueRangeService $checkValueRangeService;
    private EntityManagerInterface $entityManager;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        CheckValueRangeService $checkValueRangeService,
        EntityManagerInterface $entityManager
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->checkValueRangeService = $checkValueRangeService;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/choose-gangs', name: 'choose_gangs')]
    public function chooseGangs(Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(ChooseGangsForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data['gang1'] === $data['gang2']) {
                $this->addFlash(
                    'warning',
                    'Error: Please choose two different gangs'
                );

                $chooseGangsUrl = $this->adminUrlGenerator
                    ->setRoute('choose_gangs')
                    ->generateUrl()
                ;

                return $this->redirect($chooseGangsUrl);
            }

            $this->addFlash(
                'success',
                'You have successfully chosen gangs ' . $data['gang1'] . ' and ' . $data['gang2']
            );

            $chooseGangersUrl = $this->adminUrlGenerator
                ->setRoute('choose_scenario')
                ->generateUrl()
            ;

            $session->set('gang1', $data['gang1']->getId());
            $session->set('gang2', $data['gang2']->getId());

            return $this->redirect($chooseGangersUrl);
        }

        return $this->renderViewAndTemplate($form, 'form/choose_gangs.html.twig');
    }

    #[Route('/admin/choose-scenario', name: 'choose_scenario')]
    public function chooseScenario(Request $request, SessionInterface $session): Response
    {
        /** @var Gang $gang1 */
        $gang1 = $this->entityManager->getRepository(Gang::class)->find($session->get('gang1'));
        /** @var Gang $gang2 */
        $gang2 = $this->entityManager->getRepository(Gang::class)->find($session->get('gang2'));

        // gang rating
        if ($gang1->getRating() > $gang2->getRating()) {
            $higherGangRating = $gang1;
            $lowerGangRating = $gang2;
        } else {
            $higherGangRating = $gang2;
            $lowerGangRating = $gang1;
        }

        // battle rolls
        $gang1NumberOfGangers = count($gang1->getGangers());
        $gang2NumberOfGangers = count($gang2->getGangers());
        $battleRolls = [
          'gang1' => "<h4 class='text-white'>" . $gang1->getName() . "</h4><br>" . $gang1NumberOfGangers . " gangers -> battle roll = " . ceil($gang1NumberOfGangers * 0.25) . " / " . $gang1NumberOfGangers,
          'gang2' => "<h4 class='text-white'>" . $gang2->getName() . "</h4><br>" . $gang2NumberOfGangers . " gangers -> battle roll = " . ceil($gang2NumberOfGangers * 0.25) . " / " . $gang2NumberOfGangers,
        ];

        // scenario
        $dice1RollScenario = mt_rand(1, 6);
        $dice2RollScenario = mt_rand(1, 6);
        $dicesRoll = $dice1RollScenario + $dice2RollScenario;
        $scenarioMessage = "Scenario dice rolls" . $dicesRoll . "(" . $dice1RollScenario . " + " . $dice1RollScenario . ")\n";

        if ($dicesRoll === 2) {
            $scenarioMessage = "Dices roll (". $dice1RollScenario . " + " . $dice2RollScenario . " = " . $dicesRoll . ") Scenario chooses by player with higher gang rating: ". $higherGangRating ."(wounding hits experience doubled and full recovery convert to bitter ennemy)";
        } elseif ($dicesRoll === 3 || $dicesRoll === 4) {
            $scenarioMessage = "Dices roll (". $dice1RollScenario . " + " . $dice2RollScenario . " = " . $dicesRoll . ") Scenario chooses by player with higher gang rating: " . $higherGangRating;
        } elseif ($dicesRoll === 5 || $dicesRoll === 6) {
            $scenarioMessage = "Dices roll (". $dice1RollScenario . " + " . $dice2RollScenario . " = " . $dicesRoll . ") Gang fight scenario";
        } elseif ($dicesRoll === 7 || $dicesRoll === 8 || $dicesRoll === 9 || $dicesRoll === 10 || $dicesRoll === 11) {
            $scenarioMessage = "Dices roll (". $dice1RollScenario . " + " . $dice2RollScenario . " = " . $dicesRoll . ") Scenario chooses by player with lower gang rating: " . $lowerGangRating;
        } elseif ($dicesRoll === 12) {
            $scenarioMessage = "Dices roll (". $dice1RollScenario . " + " . $dice2RollScenario . " = " . $dicesRoll . ") Scenario chooses by player with lower gang rating: ".$lowerGangRating." (wounding hits experience doubled and full recovery convert to bitter ennemy)";
        }

        $form = $this->createForm(ChooseScenarioForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->addFlash(
                'success',
                'You have successfully chosen scenario ' . $data['scenario']->enumToString()
            );

            $chooseGangersUrl = $this->adminUrlGenerator
                ->setRoute('choose_gangers')
                ->generateUrl()
            ;

            $session->set('scenario', $data['scenario']);

            return $this->redirect($chooseGangersUrl);
        }

        return $this->renderViewAndTemplate($form, 'form/choose_scenario.html.twig', [
            'battleRolls' => $battleRolls,
            'scenarioMessage' => $scenarioMessage,
        ]);
    }

    #[Route('/choose-gangers/', name: 'choose_gangers')]
    public function chooseGangers(Request $request, GangerRepository $gangerRepository, SessionInterface $session): Response
    {
        $gangers1 = $gangerRepository->findAliveByGang($session->get('gang1'));
        $gangers2 = $gangerRepository->findAliveByGang($session->get('gang2'));

        $form = $this->createForm(ChooseGangersForm::class, null, [
            'gangers1' => $gangers1,
            'gangers2' => $gangers2,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data['gang1'] === null) {
                $this->addFlash(
                    'warning',
                    'Error: Please choose at least one ganger for gang 1'
                );

                return $this->renderViewAndTemplate($form, 'form/choose_gangers.html.twig');
            }

            if ($data['gang2'] === null) {
                $this->addFlash(
                    'warning',
                    'Error: Please choose at least one ganger for gang 2'
                );

                return $this->renderViewAndTemplate($form, 'form/choose_gangers.html.twig');
            }

            $this->addFlash(
                'success',
                'Injures are calculated'
            );

            $session->set('gang1Injuries', $data['gang1']);
            $session->set('gang2Injuries', $data['gang2']);

            $chooseTerritoriesUrl = $this->adminUrlGenerator
                ->setRoute('choose_territories')
                ->generateUrl()
            ;

            return $this->redirect($chooseTerritoriesUrl);
        }

        return $this->renderViewAndTemplate($form, 'form/choose_gangers.html.twig');
    }

    #[Route('/choose-territories/', name: 'choose_territories')]
    public function chooseTerritories(Request $request, SessionInterface $session)
    {

        /** @var Gang $gang1 */
        $gang1 = $this->entityManager->getRepository(Gang::class)->find($session->get('gang1'));
        /** @var Gang $gang2 */
        $gang2 = $this->entityManager->getRepository(Gang::class)->find($session->get('gang2'));

        $allGangers1 = $this->entityManager->getRepository(Ganger::class)->findBy(['gang' => $gang1->getId()]);
        $allGangers2 = $this->entityManager->getRepository(Ganger::class)->findBy(['gang' => $gang2->getId()]);

        $gangers1Injuries = $session->get('gang1Injuries');
        $gangers2Injuries = $session->get('gang2Injuries');

        $gang1gangerAvailableToExploitTerritories = 0;
        $gang2gangerAvailableToExploitTerritories = 0;

        foreach ($allGangers1 as $ganger) {
            if ($ganger->getType() === GangerTypeEnum::ganger) {
                foreach ($gangers1Injuries as $gangerID => $gangerStatus) {
                    if (
                        $ganger->getId() == $gangerID &&
                        $gangerStatus === 'involved_safe'
                    ) {
                        $gang1gangerAvailableToExploitTerritories += 1;
                    }
                }
            }
        }

        foreach ($allGangers2 as $ganger) {
            if ($ganger->getType() === GangerTypeEnum::ganger) {
                foreach ($gangers2Injuries as $gangerID => $gangerStatus) {
                    if (
                        $ganger->getId() == $gangerID &&
                        $gangerStatus === 'involved_safe'
                    ) {
                        $gang2gangerAvailableToExploitTerritories += 1;
                    }
                }
            }
        }

        $gang1territories = $gang1->getTerritories();
        $gang2territories = $gang2->getTerritories();

        $form = $this->createForm(ChooseTerritoriesForm::class, null, [
            'gang1territories' => $gang1territories,
            'gang2territories' => $gang2territories,
            'gang1MaxTerritoriesExploited' => $gang1gangerAvailableToExploitTerritories,
            'gang2MaxTerritoriesExploited' => $gang2gangerAvailableToExploitTerritories,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $chooseExperienceUrl = $this->adminUrlGenerator
                ->setRoute('choose_experience')
                ->generateUrl()
            ;

            $this->addFlash(
                'success',
                'Incomes from territories are calculated'
            );

            $session->set('gang1Territories', $data['gang1territories']);
            $session->set('gang2Territories', $data['gang2territories']);

            return $this->redirect($chooseExperienceUrl);
        }

        return $this->renderViewAndTemplate($form, 'form/choose_territories.html.twig', [
            'gang1MaxTerritoriesExploited' => $gang1gangerAvailableToExploitTerritories,
            'gang2MaxTerritoriesExploited' => $gang2gangerAvailableToExploitTerritories,
        ]);
    }

    #[Route('/choose-experience/', name: 'choose_experience')]
    public function chooseExperience(Request $request, SessionInterface $session)
    {
        $gangers1Injuries = $session->get('gang1Injuries');
        $gangers2Injuries = $session->get('gang2Injuries');

        $gangers1 = [];
        foreach ($gangers1Injuries as $gangerID => $gangerStatus) {
            if ($gangerStatus === 'involved_safe' || $gangerStatus === 'involved_injuries' || $gangerStatus === 'involved_high_impact_injuries') {
                $gangers1[] = $this->entityManager->getRepository(Ganger::class)->find($gangerID);
            }
        }

        $gangers2 = [];
        foreach ($gangers2Injuries as $gangerID => $gangerStatus) {
            if ($gangerStatus === 'involved_safe' || $gangerStatus === 'involved_injuries' || $gangerStatus === 'involved_high_impact_injuries') {
                $gangers2[] = $this->entityManager->getRepository(Ganger::class)->find($gangerID);
            }
        }

        $form = $this->createForm(ChooseExperienceForm::class, null, [
            'gangers1' => $gangers1,
            'gangers2' => $gangers2,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $session->set('gang1Experiences', $data['gang1']);
            $session->set('gang2Experiences', $data['gang2']);

            $url = $this->adminUrlGenerator
                ->setController(GamesCrudController::class)
                ->setAction('new')
                ->generateUrl()
            ;

            return $this->redirect($url);
        }

        return $this->renderViewAndTemplate($form, 'form/choose_experience.html.twig');
    }

    public function renderViewAndTemplate(FormInterface $form, string $template, array $options = []): Response
    {
        return $this->render($template, [
            'form' => $form->createView(),
            $options
        ]);
    }
}