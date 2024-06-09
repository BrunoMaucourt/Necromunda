<?php

namespace App\Controller\Admin;

use App\Entity\Advancement;
use App\Entity\Equipement;
use App\Entity\Game;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Injury;
use App\Entity\Skill;
use App\Entity\Territory;
use App\Entity\User;
use App\Entity\Weapon;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;
    private Security $security;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        Security $security
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->security = $security;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $links = [
            'addGang' => $this->adminUrlGenerator
                        ->setController(GangCrudController::class)
                        ->setAction('new')
                        ->generateUrl(),
            'addGanger' => $this->adminUrlGenerator
                        ->setController(GangerCrudController::class)
                        ->setAction('new')
                        ->generateUrl(),
            'addGame' => $this->adminUrlGenerator
                        ->setRoute('choose_gangs')
                        ->generateUrl(),
            'showGang' => $this->adminUrlGenerator
                        ->setController(GangCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
            'showGanger' => $this->adminUrlGenerator
                        ->setController(GangerCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
            'showGame' => $this->adminUrlGenerator
                        ->setController(GamesCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
            'showInjuries' => $this->adminUrlGenerator
                        ->setController(InjuriesCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
            'showAdvancement' => $this->adminUrlGenerator
                        ->setController(AdvancementCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
            'showEquipements' => $this->adminUrlGenerator
                        ->setController(EquipementsCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
            'showSkills' => $this->adminUrlGenerator
                        ->setController(SkillsCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
            'showTerritories' => $this->adminUrlGenerator
                        ->setController(TerritoriesCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
            'showWeapons' => $this->adminUrlGenerator
                        ->setController(WeaponsCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
            'showUser' => $this->adminUrlGenerator
                        ->setController(UserCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
        ];

        return $this->render('admin/dashboard.html.twig', [
            'links' => $links
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Necromunda');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Gangs', 'fas fa-users', Gang::class);
        yield MenuItem::linkToCrud('Gangers', 'fas fa-user-secret', Ganger::class);
        yield MenuItem::linkToCrud('Games', 'fas fa-dice', Game::class);
        if ($this->security->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Advancements', 'fas fa-trophy', Advancement::class);
            yield MenuItem::linkToCrud('Equipements', 'fas fa-toolbox', Equipement::class);
            yield MenuItem::linkToCrud('Injuries', 'fas fa-user-injured', Injury::class);
            yield MenuItem::linkToCrud('Skills', 'fas fa-user-graduate', Skill::class);
            yield MenuItem::linkToCrud('Territories', 'fas fa-warehouse', Territory::class);
            yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
            yield MenuItem::linkToCrud('Weapons', 'fas fa-gun', Weapon::class);
        }
    }
}