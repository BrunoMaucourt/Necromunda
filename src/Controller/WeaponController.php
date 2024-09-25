<?php

namespace App\Controller;

use App\Controller\Admin\DashboardController;
use App\Entity\Weapon;
use App\Enum\SpecialWeaponEnum;
use App\Enum\WeaponsEnum;
use App\Form\ChooseCost;
use App\service\WeaponService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeaponController extends AbstractController
{
    private AdminUrlGenerator $adminUrlGenerator;

    private EntityManagerInterface $entityManager;

    private WeaponService $weaponService;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager,
        WeaponService $weaponService
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
        $this->weaponService = $weaponService;
    }

    #[Route('/admin/setWeaponCostVariable/{id}', name: 'set_weapon_cost_variable')]
    public function setWeaponCostVariable(int $id, Request $request): Response
    {
        $weaponRepo = $this->entityManager->getRepository(Weapon::class);
        $weapon = $weaponRepo->find($id);

        $form = $this->createForm(ChooseCost::class, null, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $variableCost = $data['cost'];

            $weaponFixedCost = $weapon->getCost();
            $newWeaponCost = $weaponFixedCost + $variableCost;
            $weapon->setCost($newWeaponCost);

            $this->entityManager->persist($weapon);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Weapon: ' . $weapon->getName()->enumToString() .' is added to ' . $weapon->getGanger()->getName() . ' for ' . $newWeaponCost . ' credits'
            );

            $chooseGangURL = $this->adminUrlGenerator
                ->setController(DashboardController::class)
                ->generateUrl()
            ;

            return $this->redirect($chooseGangURL);
        }

        return $this->render('form/choose_cost.html.twig', [
            'form' => $form->createView(),
            'weapon' => $weapon
        ]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/admin/weaponInformations', name: 'weapon_informations')]
    public function WeaponInformations(Request $request): Response
    {
        $allWeapons = WeaponsEnum::cases();
        $allSpecialWeapons = SpecialWeaponEnum::cases();

        foreach ($allWeapons as $key => $weapon) {
            if (
                $weapon == WeaponsEnum::SHOTGUN ||
                $weapon == WeaponsEnum::COMBAT_RIFLE ||
                $weapon == WeaponsEnum::PLASMA_GUN ||
                $weapon == WeaponsEnum::PLASMA_PISTOL ||
                $weapon == WeaponsEnum::MISSILE_LAUNCHER
            ) {
                unset($allWeapons[$key]);
            }
        }

        return $this->render('informations/weapon.html.twig', [
            'specials' => $allSpecialWeapons,
            'weapons' => $allWeapons
        ]);
    }
}