<?php

namespace App\Controller;

use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StashController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/addWeapon/{id}', name: 'add_weapon_in_stash')]
    public function addWeaponInStash(int $id)
    {
        // Get weapon
    }
}