<?php
namespace App\EventSubscriber;

use App\Controller\Admin\GangerCrudController;
use App\Exception\GangerVerificationFailedException;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private $adminUrlGenerator;
    private RequestStack $requestStack;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        RequestStack $requestStack
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof GangerVerificationFailedException) {
            $request = $this->requestStack->getCurrentRequest();
            $session = $request->getSession();
            $flashBag = $session->getFlashBag();
            $flashBag->add(
                'warning',
                'You can have two leaders or three heavies alive in the same gang'
            );

            $url = $this->adminUrlGenerator
                ->setController(GangerCrudController::class)
                ->setAction('new')
                ->generateUrl()
            ;
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }
}