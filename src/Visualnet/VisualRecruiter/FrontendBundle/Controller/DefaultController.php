<?php

namespace Visualnet\VisualRecruiter\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default frontend controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\FrontendBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class DefaultController extends Controller
{

    /**
     * Make default site by language
     * 
     * @param Request $request
     * @return Response 
     */
    public function indexAction(Request $request)
    {        
        $session = $request->getSession();

        if (!$session->get("firstRequest") or is_null($request->get("_locale"))) {

            $language = $request->getPreferredLanguage($this->container->getParameter("langs"));
            $session->set("firstRequest", true);
            $session->setLocale($language);

            return $this->redirect($this->generateUrl("FrontendBundle_homepage_locale", array("_locale" => $language)));
        }
        
        $response = new Response();
        
        $response = $this->render("FrontendBundle:Default:index.html.twig");
        $response->setETag(md5($response->getContent()));
        $response->isNotModified($this->getRequest());        

        return $response;
    }

}
