<?php
 
namespace Visualnet\VisualRecruiter\UserBundle\EventListener;
 
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\KernelEvents;
 
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * SecurityListener.
 */
class SecurityListener
{   
    /**
     * @var Router $router
     */
    protected $router;
 
    /**
     * @var SecurityContext $security
     */
    protected $security;
 
    /**
     * @var EventDispatcher $dispatcher
     */
    protected $dispatcher;
 
    /**
     * Constructs a new instance of SecurityListener.
     * 
     * @param Router $router The router
     * @param SecurityContext $security The security context
     * @param EventDispatcher $dispatcher The event dispatcher
     */
    public function __construct(Router $router, SecurityContext $security, EventDispatcher $dispatcher)
    {
        $this->router = $router;
        $this->security = $security;
        $this->dispatcher = $dispatcher;
    }
 
    /**
     * Invoked after a successful login.
     * 
     * @param InteractiveLoginEvent $event The event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        
//        if ($this->security->isGranted('ROLE_SUPERADMIN')) {
//            // since the user is an admin attach this listener for kernel.response event
//            $this->dispatcher->addListener(KernelEvents::RESPONSE, array($this, 'onKernelResponse'));
//        }
        
        
    }
 
    /**
     * Invoked after the response has been created.
     * 
     * @param FilterResponseEvent $event The event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = new RedirectResponse($this->router->generate('UserBundle_user_list'));
        $event->setResponse($response);
    }
}