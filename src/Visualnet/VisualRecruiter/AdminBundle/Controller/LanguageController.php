<?php

namespace Visualnet\VisualRecruiter\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Language controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\AdminBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class LanguageController extends Controller
{

    /**
     * Change language data
     *   
     * @param Request $request
     * @param string $language
     * @return Response
     */
    public function changeAction(Request $request, $language)
    {
        $session = $request->getSession();
        $session->setLocale($language);
        $langs = $this->container->getParameter("langs");

        // add extra signs to replace
        foreach ($langs as $key => $lang) {
            $langs[$key] = '/' . $lang . '/';
        }

        $redirect = str_replace($langs, '/' . $language . '/', $request->server->get("HTTP_REFERER"));

        return new RedirectResponse($redirect);
    }

}
