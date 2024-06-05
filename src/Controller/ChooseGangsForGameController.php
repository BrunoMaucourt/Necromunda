<?php

namespace App\Controller;

use App\Controller\Admin\GamesCrudController;
use App\Form\ChooseGangersForm;
use App\Form\ChooseGangsForm;
use App\Repository\GangerRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChooseGangsForGameController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin/choose-gangs', name: 'choose_gangs')]
    public function chooseGangs(Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(ChooseGangsForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data['gang1'] === $data['gang2']) {
                $this->addFlash(
                    'warning',
                    'Error: Please choose two different gangs'
                );

                return $this->renderGangsFormView($form);
            }

            $this->addFlash(
                'success',
                'You have successfully chosen gangs ' . $data['gang1'] . ' and ' . $data['gang2']
            );

            $session->set('gang1', $data['gang1']->getId());
            $session->set('gang2', $data['gang2']->getId());

            return $this->redirectToRoute('choose_gangers');
        }

        return $this->renderGangsFormView($form);
    }
    public function renderGangsFormView(FormInterface $form): Response
    {
        return $this->render('form/choose_gangs.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}