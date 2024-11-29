<?php

namespace App\service;

use App\Entity\Weapon;
use App\Enum\SpecialWeaponEnum;
use App\Enum\WeaponsEnum;
use Doctrine\ORM\EntityManagerInterface;

class EquipementService
{
    private EntityManagerInterface $entityManager;

    public function __construct (
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function mergeAndSortEquipements(array $listOfEquipements, array $listOfWeaponEquipements): ?array
    {
        $merged = array_merge($listOfEquipements, $listOfWeaponEquipements);

        $uniqueEquipements = [];
        foreach ($merged as $equipement) {
            $uniqueEquipements[$equipement->getName()->enumToString()] = $equipement;
        }

        $uniqueEquipements = array_values($uniqueEquipements);

        usort($uniqueEquipements, fn($a, $b) => $a->getName()->enumToString() <=> $b->getName()->enumToString());

        return $uniqueEquipements;
    }
}