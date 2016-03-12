<?php

namespace Visualnet\VisualRecruiter\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Visualnet\MenuBundle\Model;

/**
 * Default menu controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\FrontendBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class MenuController extends Controller
{

    /**
     * Show menu data
     *   
     * @param Request $request
     * @param string $slug
     * @return Response
     */
    public function showAction(Request $request, $slug)
    {
        $locale = $this->container->get("utils")->getRegionLocale($this->get("session")->getLocale());

        $object = Model\MenuQuery::create()
                        ->joinWithI18n()
                        ->useI18nQuery($locale)
                        ->filterBySlug($slug)
                        ->endUse()
                        ->filterByIsActive(true)->findOne();

        if ($object == null) {
            throw $this->createNotFoundException("Brak takiej strony");
        }

        return $this->render("FrontendBundle:Menu:show.html.twig", array("object" => $object));
    }

}
