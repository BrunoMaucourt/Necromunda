<?php

namespace App\Controller\Admin;

use App\Entity\Equipements;
use App\Entity\Games;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Injuries;
use App\Entity\Skills;
use App\Entity\Territories;
use App\Entity\User;
use App\Entity\Weapons;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(UserCrudController::class)->generateUrl();

        return $this->redirect($url);
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Necromunda');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Gangs', 'fas fa-users', Gang::class);
        yield MenuItem::linkToCrud('Gangers', 'fas fa-user-secret', Ganger::class);
        yield MenuItem::linkToCrud('Games', 'fas fa-dice', Games::class);
        yield MenuItem::linkToCrud('Territories', 'fas fa-warehouse', Territories::class);
        yield MenuItem::linkToCrud('Injuries', 'fas fa-user-injured', Injuries::class);
        yield MenuItem::linkToCrud('Skills', 'fas fa-user-graduate', Skills::class);
        yield MenuItem::linkToCrud('Weapons', 'fas fa-gun', Weapons::class);
        yield MenuItem::linkToCrud('Equipements', 'fas fa-toolbox', Equipements::class);
    }
}