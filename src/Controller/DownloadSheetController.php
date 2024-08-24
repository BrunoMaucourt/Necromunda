<?php

namespace App\Controller;

use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadSheetController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/generateGangTable/{id}', name: 'generate_gang_table')]
    public function generateGangTable(int $id): Response
    {
        $gangRepo = $this->entityManager->getRepository(Gang::class);
        $gangerRepo = $this->entityManager->getRepository(Ganger::class);

        $gang = $gangRepo->find($id);
        $gangers = $gangerRepo->findAliveByGang($id);

        return $this->render('download/gangSheet.html.twig', [
            'gang' => $gang,
        ]);
    }
}
