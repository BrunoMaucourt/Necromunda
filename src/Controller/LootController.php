<?php

namespace App\Controller;

use App\Controller\Admin\GangCrudController;
use App\Entity\Equipement;
use App\Entity\Gang;
use App\Entity\Ganger;
use App\Entity\Loot;
use App\Entity\Weapon;
use App\Enum\EquipementsEnum;
use App\Enum\LootEnum;
use App\Form\ChooseBionic;
use App\Form\SelectGangerForItems;
use App\Form\SelectWeaponForItems;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class LootController extends AbstractController
{
    private AdminUrlGenerator $adminUrlGenerator;

    private EntityManagerInterface $entityManager;

    private TranslatorInterface $translator;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator,
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    #[Route('/admin/buyLoot/{id}', name: 'buy_loot')]
    public function buyLoot(AdminContext $context, int $id, Request $request): Response
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

                $loot->setActive(false);

                $this->entityManager->persist($gang);
                $this->entityManager->persist($weapon);
                $this->entityManager->persist($loot);
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

        if ( $loot->getName()->getType() === LootEnum::EQUIPMENT_FOR_GANGER ) {
            $gangers = $gangerRepo->findAliveByGang($gangID);

            if ($loot->getName() === LootEnum::Bionic) {

                $chooseBionicURL = $this->adminUrlGenerator
                    ->setRoute('buy_bionic_loot', ['id' => $id])
                    ->generateUrl()
                ;

                return $this->redirect($chooseBionicURL);
            } else {
                $form = $this->createForm(SelectGangerForItems::class, null, ['gangers' => $gangers]);
                $template = "form/choose_ganger_for_items.html.twig";
            }

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $gangerId = $data['ganger'];
                $ganger = $gangerRepo->find($gangerId);
                $gangNewCredit = $gangCredit - $loot->getCost();
                $gang->setCredits($gangNewCredit);

                $equipement = new Equipement();
                $equipement->setName($loot->getName()->getEquipementEnum());
                $equipement->setCost($loot->getCost());
                $equipement->setGanger($ganger);
                $equipement->setLoot(true);

                $loot->setActive(false);

                $this->entityManager->persist($gang);
                $this->entityManager->persist($equipement);
                $this->entityManager->persist($loot);
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

        if ( $loot->getName()->getType() === LootEnum::EQUIPMENT_FOR_WEAPON ) {
            $weapons = $weaponRepo->findAllWeaponsByGang($gangID);
            $form = $this->createForm(SelectWeaponForItems::class, null, ['weapons' => $weapons]);
            $template = "form/choose_weapon_for_items.html.twig";
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $weaponId = $data['weapon'];
                $weapon = $weaponRepo->find($weaponId);
                $gangNewCredit = $gangCredit - $loot->getCost();
                $gang->setCredits($gangNewCredit);

                $equipement = new Equipement();
                $equipement->setName($loot->getName()->getEquipementEnum());
                $equipement->setCost($loot->getCost());
                $equipement->setWeapon($weapon);
                $equipement->setLoot(true);

                $loot->setActive(false);

                $this->entityManager->persist($gang);
                $this->entityManager->persist($equipement);
                $this->entityManager->persist($loot);
                $this->entityManager->flush();

                $this->addFlash(
                    'success',
                    'Loot: ' . $loot->getName()->enumToString() .' is added to ' . $weapon->getName()->enumToString() . ' for ' . $loot->getCost() . ' credits'
                );

                $chooseGangURL = $this->adminUrlGenerator
                    ->setController(GangCrudController::class)
                    ->generateUrl()
                ;

                return $this->redirect($chooseGangURL);
            }
        }

        return $this->render($template, [
            'form' => $form->createView(),
            'item' => $loot
        ]);
    }

    #[Route('/admin/buyBionicLoot/{id}', name: 'buy_bionic_loot')]
    public function buyBionicLoot(int $id, Request $request): Response
    {
        $lootRepo = $this->entityManager->getRepository(Loot::class);
        $loot = $lootRepo->find($id);

        $allBionics = [
            'bionic arm' => EquipementsEnum::BionicArm,
            'bionic eye' => EquipementsEnum::BionicEye,
            'bionic leg' => EquipementsEnum::BionicLeg,
            'bionic chest' => EquipementsEnum::BionicChest,
            'bionic implant' => EquipementsEnum::BionicImplant,
        ];

        $form = $this->createForm(ChooseBionic::class, null, ['bionics' => $allBionics]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $bionicType = $data['bionic'];

            switch ($bionicType) {
                case LootEnum::BionicArm->enumToString():
                    $bionicEnum = LootEnum::BionicArm;
                    break;
                case LootEnum::BionicEye->enumToString():
                    $bionicEnum = LootEnum::BionicEye;
                    break;
                case LootEnum::BionicLeg->enumToString():
                    $bionicEnum = LootEnum::BionicLeg;
                    break;
                case LootEnum::BionicChest->enumToString():
                    $bionicEnum = LootEnum::BionicChest;
                    break;
                case LootEnum::BionicImplant->enumToString():
                    $bionicEnum = LootEnum::BionicImplant;
                    break;
            }

            $bionic = new Loot();
            $bionic->setName($bionicEnum);
            $bionic->setCost($loot->getCost());
            $bionic->setGang($loot->getGang());
            $bionic->setGame($loot->getGame());

            $this->entityManager->persist($bionic);
            $this->entityManager->remove($loot);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                $this->translator->trans('Loot :') . $bionic->getName()->enumToString() . $this->translator->trans(' was choose')
            );

            $buyBionicUrl = $this->adminUrlGenerator
                ->setRoute('buy_loot', ['id' => $bionic->getId()])
                ->generateUrl()
            ;

            return $this->redirect($buyBionicUrl);
        }

        return $this->render("form/choose_bionic.html.twig", [
            'form' => $form->createView(),
            'bionics' => $allBionics
        ]);
    }
}