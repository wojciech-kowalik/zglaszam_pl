<?php

namespace Visualnet\VisualRecruiter\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default admin controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\AdminBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->get("firstRequest") or is_null($request->get("_locale"))) {

            $language = $request->getPreferredLanguage($this->container->getParameter("langs"));
            $session->set("firstRequest", true);
            $session->setLocale($language);

            return $this->redirect($this->generateUrl("AdminBundle_homepage_locale", array("_locale" => $language)));
        }     
        
        return $this->render('AdminBundle:Default:index.html.twig');
    }
   
}
