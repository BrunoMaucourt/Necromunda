<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/admin/avatars', name: 'gallery')]
    public function showAvatars(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        $games = $entityManager->getRepository(Game::class)->findAll();
        $gangs = $entityManager->getRepository(Gang::class)->findAll();
        $gangers = $entityManager->getRepository(Ganger::class)->findAll();

        return $this->render('admin/gallery.html.twig', [
            'users' => $users,
            'games' => $games,
            'gangs' => $gangs,
            'gangers' => $gangers,
        ]);
    }
}