<?php

namespace Visualnet\VisualRecruiter\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model;

/**
 * Recruitment controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\AdminBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class RecruitmentController extends Controller
{

    /**
     * Change recruitment
     *   
     * @param Request $request
     * @param string $language
     * @return Response
     */
    public function changeAction(Request $request, $id)
    {
        
        $session = $request->getSession();
        
        $recruitment = Model\RecruitmentQuery::create()
                ->findOneById($id)->toArray();
                
        $session->set("recruitment", $recruitment);

        return new RedirectResponse($this->generateUrl("RecruitmentBundle_list").".html");
    }

}
