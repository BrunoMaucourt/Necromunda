<?php

namespace App\Controller;

use App\Controller\Admin\GangCrudController;
use App\Entity\Ganger;
use App\Entity\Weapon;
use App\Form\SelectGangerForItems;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StashController extends AbstractController
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

    #[Route('/admin/addWeapon/{id}', name: 'add_weapon_in_stash')]
    public function addWeaponInStash(int $id): Response
    {
        $weaponRepo = $this->entityManager->getRepository(Weapon::class);
        $weapon = $weaponRepo->find($id);

        $ganger = $weapon->getGanger();
        $gang = $ganger->getGang();
        $gang->addWeapon($weapon);
        $ganger->removeWeapon($weapon);

        $this->entityManager->persist($gang);
        $this->entityManager->persist($ganger);
        $this->entityManager->persist($weapon);
        $this->entityManager->flush();

        $this->addFlash(
            'success',
            'Weapon: '. $weapon->getName()->enumToString() .' is added to stash'
        );

        $chooseGangURL = $this->adminUrlGenerator
            ->setController(gangCrudController::class)
            ->generateUrl()
        ;

        return $this->redirect($chooseGangURL);
    }

    #[Route('/admin/removeWeapon/{id}', name: 'remove_weapon_from_stash')]
    public function removeWeaponFromStash(int $id, Request $request): Response
    {
        $gangerRepo = $this->entityManager->getRepository(Ganger::class);
        $weaponRepo = $this->entityManager->getRepository(Weapon::class);
        $weapon = $weaponRepo->find($id);
        $gang = $weapon->getStash();
        $allGangersAvailable = $gangerRepo->findAliveByGang($gang->getId());

        $form = $this->createForm(SelectGangerForItems::class, null, ['gangers' => $allGangersAvailable]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $gangerId = $data['ganger'];
            $ganger = $gangerRepo->find($gangerId);

            $ganger->addWeapon($weapon);
            $gang->removeWeapon($weapon);
            $this->entityManager->persist($ganger);
            $this->entityManager->persist($gang);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Weapon: ' . $weapon->getName()->enumToString() .' is removed to stash and added to ' . $ganger->getName()
            );

            $chooseGangURL = $this->adminUrlGenerator
                ->setController(gangCrudController::class)
                ->generateUrl()
            ;

            return $this->redirect($chooseGangURL);
        }

        return $this->render('form/choose_ganger_for_items.html.twig', [
            'form' => $form->createView(),
            'item' => $weapon
        ]);
    }
}