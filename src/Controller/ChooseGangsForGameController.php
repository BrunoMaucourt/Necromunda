<?php

namespace App\Controller;

use App\Controller\Admin\GamesCrudController;
use App\Form\ChooseGangersForm;
use App\Form\ChooseGangsForm;
use App\Repository\GangerRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChooseGangsForGameController extends AbstractController
{
    private AdminUrlGenerator $adminUrlGenerator;
    private CheckValueRangeService $checkValueRangeService;
    private EntityManagerInterface $entityManager;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        CheckValueRangeService $checkValueRangeService,
        EntityManagerInterface $entityManager
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->checkValueRangeService = $checkValueRangeService;
        $this->entityManager = $entityManager;
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

                return $this->redirectToRoute('/choose-gangers/');
            }

            $this->addFlash(
                'success',
                'You have successfully chosen gangs ' . $data['gang1'] . ' and ' . $data['gang2']
            );

            $chooseGangersUrl = $this->adminUrlGenerator
                ->setRoute('choose_gangers')
                ->generateUrl()
            ;

            $session->set('gang1', $data['gang1']->getId());
            $session->set('gang2', $data['gang2']->getId());

            return $this->redirect($chooseGangersUrl);
        }

        return $this->renderViewAndTemplate($form, 'form/choose_gangs.html.twig');
    }
    public function renderGangsFormView(FormInterface $form): Response
    {
        return $this->render('form/choose_gangs.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}