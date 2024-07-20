<?php

namespace App\Controller;

use App\Controller\Admin\GangCrudController;
use App\Entity\Gang;
use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            'Weapon: '. $weapon->getName().' is added to stash'
        );

        $chooseGangURL = $this->adminUrlGenerator
            ->setController(gangCrudController::class)
            ->generateUrl()
        ;

        return $this->redirect($chooseGangURL);
    }
    {
        // Get weapon
    }
}