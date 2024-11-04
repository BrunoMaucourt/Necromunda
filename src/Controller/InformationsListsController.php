<?php

namespace App\Controller;

use App\Enum\EquipementsEnum;
use App\Enum\SpecialWeaponEnum;
use App\Enum\WeaponsEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationsListsController extends AbstractController
{
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

    #[Route('/{_locale<%app.supported_locales%>}/admin/equipementInformations', name: 'equipement_informations')]
    public function EquipementInformations(Request $request): Response
    {
        $allEquipments = EquipementsEnum::cases();

        return $this->render('informations/equipement.html.twig', [
            'equipements' => $allEquipments
        ]);
    }
}