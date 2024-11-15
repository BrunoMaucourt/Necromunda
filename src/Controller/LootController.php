<?php

namespace App\Controller;

use App\Controller\Admin\GangCrudController;
use App\Entity\Equipement;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Loot;
use App\Entity\Weapon;
use App\Enum\LootEnum;
use App\Form\SelectGangerForItems;
use App\Form\SelectWeaponForItems;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LootController extends AbstractController
{
    private AdminUrlGenerator $adminUrlGenerator;

    private EntityManagerInterface $entityManager;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager,
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/buyLoot/{id}', name: 'buy_loot')]
    public function buyLoot(int $id, Request $request): Response
    {
        $equipementRepo = $this->entityManager->getRepository(Equipement::class);
        $gangRepo = $this->entityManager->getRepository(Gang::class);
        $gangerRepo = $this->entityManager->getRepository(Ganger::class);
        $lootRepo = $this->entityManager->getRepository(Loot::class);
        $weaponRepo = $this->entityManager->getRepository(Weapon::class);

        $loot = $lootRepo->find($id);
        $gangID = $loot->getGang()->getId();

        $gang = $gangRepo->find($gangID);
        $gangCredit = $gang->getCredits();

        if ( $loot->getName()->getType() === LootEnum::WEAPON ) {
            $gangers = $gangerRepo->findAliveByGang($gangID);
            $form = $this->createForm(SelectGangerForItems::class, null, ['gangers' => $gangers]);
            $template = "form/choose_ganger_for_items.html.twig";
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $gangerId = $data['ganger'];
                $ganger = $gangerRepo->find($gangerId);
                $gangNewCredit = $gangCredit - $loot->getCost();
                $gang->setCredits($gangNewCredit);

                $weapon = new Weapon();
                $weapon->setName($loot->getName()->getWeaponEnum());
                $weapon->setCost($loot->getCost());
                $weapon->setGanger($ganger);
                $weapon->setLoot(true);

                $this->entityManager->persist($gang);
                $this->entityManager->persist($weapon);
                $this->entityManager->remove($loot);
                $this->entityManager->flush();

                $this->addFlash(
                    'success',
                    'Loot: ' . $loot->getName()->enumToString() .' is added to ' . $ganger->getName() . ' for ' . $loot->getCost() . ' credits'
                );

                $chooseGangURL = $this->adminUrlGenerator
                    ->setController(GangCrudController::class)
                    ->generateUrl()
                ;

                return $this->redirect($chooseGangURL);
            }
        }

