<?php

namespace App\Controller;

use App\Controller\Admin\DashboardController;
use App\Controller\Admin\GangCrudController;
use App\Entity\Equipement;
use App\Entity\Item;
use App\Entity\Weapon;
use App\Form\ChooseCost;
use App\Form\ChooseYesNoForm;
use App\service\GangService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    private AdminUrlGenerator $adminUrlGenerator;

    private EntityManagerInterface $entityManager;

    private GangService $gangService;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager,
        GangService $gangService
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
        $this->gangService = $gangService;
    }

    #[Route('/admin/setItemCostVariable/{id}', name: 'set_item_cost_variable')]
    public function setItemCostVariable(int $id, string $item, Request $request): Response
    {
        if ( $item === 'App\Entity\Equipement' ) {
            $equipementRepo = $this->entityManager->getRepository(Equipement::class);
            $itemToProcess = $equipementRepo->findAll();
            dump($itemToProcess);
            $itemToProcess = $equipementRepo->find($id);
            dump($equipementRepo);
            dump($itemToProcess);
        }

        if ( $item === 'App\Entity\Weapon' ) {
            $weaponRepo = $this->entityManager->getRepository(Weapon::class);
            $itemToProcess = $weaponRepo->find($id);
            dump($weaponRepo);
            dump($itemToProcess);
        }

        $form = $this->createForm(ChooseCost::class, null, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $variableCost = $data['cost'];

            $itemToProcessFixedCost = $itemToProcess->getCost();
            $newItemCost = $itemToProcessFixedCost + $variableCost;
            $itemToProcess->setCost($newItemCost);

            $this->entityManager->persist($itemToProcess);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Item: ' . $itemToProcess->getName()->enumToString() .' is added to ' . $itemToProcess->getGanger()->getName() . ' for ' . $newItemCost . ' credits'
            );

            $chooseGangURL = $this->adminUrlGenerator
                ->setController(DashboardController::class)
                ->generateUrl()
            ;


            return $this->redirect($chooseGangURL);
        }


        return $this->render('form/choose_cost.html.twig', [
            'form' => $form->createView(),
            'item' => $itemToProcess
        ]);
    }

    #[Route('/admin/sellItem/{id}/{type}', name: 'sell_item')]
    public function sellItem(int $id, Request $request, string $type = ''): Response
    {
        if ($type === 'equipement') {
            $equipementRepo = $this->entityManager->getRepository(Equipement::class);
            $item = $equipementRepo->find($id);
            if ($item->getGanger()->getGang()) {
                $gang = $item->getGanger()->getGang();
            } else {
                $gang = $item->getWeapon()->getGanger()->getGang();
            }
        }

        if ($type === 'weapon') {
            $weaponRepo = $this->entityManager->getRepository(Weapon::class);
            $item = $weaponRepo->find($id);
            if ($item->getGanger()->getGang()) {
                $gang = $item->getGanger()->getGang();
            } else {
                $gang = $item->getStash();
            }
        }

        $cost = $item->getCost();
        $creditsToEarn = round($cost / 2);

        $form = $this->createForm(ChooseYesNoForm::class, null, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton()->getConfig()->getName() === 'yes') {

                if ($item instanceof Weapon) {
                    if ($item->getGanger()->getGang()) {
                        $gang->removeWeapon($item);
                        $this->entityManager->persist($gang);
                    } else {
                        $ganger = $item->getGanger();
                        $ganger->removeWeapon($item);
                        $this->entityManager->persist($ganger);
                    }
                }

                $gangCredits = $gang->getCredits();
                $newCredits = $gangCredits + $creditsToEarn;
                $gang->setCredits($newCredits);

                if ($type === 'weapon') {
                    if ($item->getGanger()->getGang()) {
                        $item->getGanger()->removeWeapon($item);
                    } else {
                        $item->getStash()->removeWeapon($item);
                    }
                }

                $this->entityManager->persist($gang);
                $this->entityManager->flush();

                $this->addFlash(
                    'success',
                    $type . ': ' . $item->getName()->enumToString() .' is sell to ' . $creditsToEarn . ' credits'
                );

                $chooseGangURL = $this->adminUrlGenerator
                    ->setController(gangCrudController::class)
                    ->generateUrl()
                ;

                return $this->redirect($chooseGangURL);
            }
        }

        return $this->render('form/sell_item.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
            'itemCost' => $creditsToEarn,
            'type' => $type,
        ]);
    }
}