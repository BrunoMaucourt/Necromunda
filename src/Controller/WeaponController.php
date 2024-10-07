<?php

namespace App\Controller;

use App\Controller\Admin\DashboardController;
use App\Entity\Equipement;
use App\Entity\Item;
use App\Entity\Weapon;
use App\Form\ChooseCost;
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
}