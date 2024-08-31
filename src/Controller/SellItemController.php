<?php

namespace App\Controller;

use App\Controller\Admin\GangCrudController;
use App\Entity\Weapon;
use App\Form\ChooseCost;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SellItemController extends AbstractController
{
    private AdminUrlGenerator $adminUrlGenerator;

    private EntityManagerInterface $entityManager;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/sellItem/{id}/{type}', name: 'sell_item')]
    public function sellItem(int $id, Request $request, string $type = ''): Response
    {
        if ($type ==! '') {

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

        $form = $this->createForm(ChooseCost::class, null, []);
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

                if ($item->getGanger()->getGang()) {
                    $item->getGanger()->removeWeapon($item);
                } else {
                    $item->getStash()->removeWeapon($item);
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