<?php

namespace App\Controller\Admin;

use App\Entity\Advancement;
use App\Entity\Equipement;
use App\Entity\Game;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Injury;
use App\Entity\Loot;
use App\Entity\Skill;
use App\Entity\Territory;
use App\Entity\User;
use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    private EntityManagerInterface $entityManager;

    private RequestStack $requestStack;

    private Security $security;

    private TranslatorInterface $translator;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        Security $security,
        TranslatorInterface $translator,
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->security = $security;
        $this->translator = $translator;
    }

    #[Route('/{_locale<%app.supported_locales%>}/admin', name: 'admin')]
    public function index(): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $locale = $request ? $request->getLocale() : 'en';

        dump($locale);

        $this->translator->setLocale($locale);

        $translatedMessage = $this->translator->trans('message.hello_world');

        $linksAdd = [
            'Gang' => [
                'url' => $this->adminUrlGenerator
                            ->setController(GangCrudController::class)
                            ->setAction('new')
                            ->generateUrl(),
                'icon' => 'fas fa-users',
                'text' => $this->translator->trans('Add gang'),
            ],
            'Ganger' => [
                'url' => $this->adminUrlGenerator
                            ->setController(GangerCrudController::class)
                            ->setAction('new')
                            ->generateUrl(),
                'icon' => 'fas fa-user-secret',
                'text' => $this->translator->trans('Add ganger'),
            ],
            'Game' => [
                'url' => $this->adminUrlGenerator
                            ->setRoute('choose_gangs')
                            ->generateUrl(),
                'icon' => 'fas fa-dice',
                'text' => $this->translator->trans('Add game'),
            ],
        ];

        $linksShowPrincipal = [
            'Gang' => [
                'url' => $this->adminUrlGenerator
                            ->setController(GangCrudController::class)
                            ->setAction('index')
                            ->generateUrl(),
                'icon' => 'fas fa-users',
                'text' => $this->translator->trans('Show all gangs'),
            ],
            'Ganger' => [
                'url' => $this->adminUrlGenerator
                            ->setController(GangerCrudController::class)
                            ->setAction('index')
                            ->generateUrl(),
                'icon' => 'fas fa-user-secret',
                'text' => $this->translator->trans('Show all gangers'),
            ],
            'Game' => [
                'url' => $this->adminUrlGenerator
                            ->setController(GamesCrudController::class)
                            ->setAction('index')
                            ->generateUrl(),
                'icon' => 'fas fa-dice',
                'text' => $this->translator->trans('Show all games'),
            ]
        ];

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $linksShowSecondary = [
                'Advancement' => [
                    'url' => $this->adminUrlGenerator
                        ->setController(AdvancementCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
                    'icon' => 'fas fa-award',
                    'text' => $this->translator->trans('Show all advancements'),
                ],
                'Equipements' => [
                    'url' => $this->adminUrlGenerator
                        ->setController(AdvancementCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
                    'icon' => 'fas fa-toolbox',
                    'text' => $this->translator->trans('Show all equipements'),
                ],
                'Injuries' => [
                    'url' => $this->adminUrlGenerator
                        ->setController(InjuriesCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
                    'icon' => 'fas fa-user-injured',
                    'text' => $this->translator->trans('Show all injuries'),
                ],
                'Loots' => [
                    'url' => $this->adminUrlGenerator
                        ->setController(LootCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
                    'icon' => 'fas fa-gem',
                    'text' => $this->translator->trans('Show all loots'),
                ],
                'Skills' => [
                    'url' => $this->adminUrlGenerator
                        ->setController(SkillsCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
                    'icon' => 'fas fa-user-graduate',
                    'text' => $this->translator->trans('Show all skills'),
                ],
                'Territories' => [
                    'url' => $this->adminUrlGenerator
                        ->setController(TerritoriesCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
                    'icon' => 'fas fa-warehouse',
                    'text' => $this->translator->trans('Show all territories'),
                ],
                'Weapons' => [
                    'url' => $this->adminUrlGenerator
                        ->setController(WeaponsCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
                    'icon' => 'fas fa-gun',
                    'text' => $this->translator->trans('Show all weapons'),
                ],
                'Users' => [
                    'url' => $this->adminUrlGenerator
                        ->setController(UserCrudController::class)
                        ->setAction('index')
                        ->generateUrl(),
                    'icon' => 'fas fa-user',
                    'text' => $this->translator->trans('Show all users'),
                ],
            ];
        } else {
            $linksShowSecondary = [];
        }

        // Statistics
        $errorMessageNoData = 'no data';
        $gangRepository = $this->entityManager->getRepository(Gang::class);

        $highestRating['message'] = 'Highest gang rating';
        if ($gangRepository->getGangWithHighestRating() ==! null) {
            $gang = $gangRepository->find($gangRepository->getGangWithHighestRating());
            $highestRating['gang'] = $gang->getName();
            $highestRating['data'] = $gang->getRating();
        } else {
            $highestRating['gang'] = '';
            $highestRating['data'] = $errorMessageNoData;
        };

        $highestCredits['message'] = 'Highest gang credits';
        if ($gangRepository->getGangWithHighestCredits() ==! null) {
            $gang = $gangRepository->find($gangRepository->getGangWithHighestCredits());
            $highestCredits['gang'] = $gang->getName();
            $highestCredits['data'] = $gang->getCredits();
        } else {
            $highestCredits['gang'] = '';
            $highestCredits['data'] = $errorMessageNoData;
        };

        $statistics = [
            'highestRating' => $highestRating,
            'highestCredits' => $highestCredits,
        ];

        return $this->render('admin/dashboard.html.twig', [
            'linksAdd' => $linksAdd,
            'linksShowPrincipal' => $linksShowPrincipal,
            'linksShowSecondary' => $linksShowSecondary,
            'statistics' => $statistics,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Necromunda');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard($this->translator->trans('Dashboard'), 'fa fa-home');
        yield MenuItem::linkToCrud($this->translator->trans('Gangs'), 'fas fa-users', Gang::class);
        yield MenuItem::linkToCrud($this->translator->trans('Gangers'), 'fas fa-user-secret', Ganger::class);
        yield MenuItem::linkToCrud($this->translator->trans('Games'), 'fas fa-dice', Game::class);
        if ($this->security->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud($this->translator->trans('Advancements'), 'fas fa-award', Advancement::class);
            yield MenuItem::linkToCrud($this->translator->trans('Equipements'), 'fas fa-toolbox', Equipement::class);
            yield MenuItem::linkToCrud($this->translator->trans('Injuries'), 'fas fa-user-injured', Injury::class);
            yield MenuItem::linkToCrud($this->translator->trans('Loots'), 'fas fa-gem', Loot::class);
            yield MenuItem::linkToCrud($this->translator->trans('Skills'), 'fas fa-user-graduate', Skill::class);
            yield MenuItem::linkToCrud($this->translator->trans('Territories'), 'fas fa-warehouse', Territory::class);
            yield MenuItem::linkToCrud($this->translator->trans('Users'), 'fas fa-user', User::class);
            yield MenuItem::linkToCrud($this->translator->trans('Weapons'), 'fas fa-gun', Weapon::class);
        }
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if (!$user instanceof User) {
            throw new \LogicException('The user must be an instance of '.User::class.'.');
        }

        $urlCurrentUserEditPage = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->setAction('edit')
            ->setEntityId($user->getId())
            ->generateUrl();

        return parent::configureUserMenu($user)
            ->addMenuItems([
                MenuItem::linkToUrl($this->translator->trans('Settings'), 'fa fa-cog', $urlCurrentUserEditPage),
        ]);
    }

    #[Route('/admin-context/{route}/{id}/{type}', name: 'admin-context')]
    public function adminContext(string $route, int $id, string $type = ''): RedirectResponse
    {
        $url = $this->adminUrlGenerator
            ->setRoute($route, ['id' => $id, 'type' => $type])
            ->generateUrl()
        ;

        return $this->redirect($url);
    }
}