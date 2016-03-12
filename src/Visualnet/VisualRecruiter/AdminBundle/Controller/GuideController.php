<?php

namespace Visualnet\VisualRecruiter\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Guide controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\AdminBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class GuideController extends Controller
{
    
    /**
     * Default action
     *   
     * @param Request $request
     * @return Response
     */    
    public function indexAction(Request $request)
    {
                
        return $this->render('AdminBundle:Guide:index.html.twig');
    }
    
    /**
     * Element guide action
     *   
     * @param Request $request
     * @return Response
     */       
    public function elementAction(Request $request)
    {
        return $this->render('AdminBundle:Guide:element.html.twig', array("id" => $request->get("id")));
    }
    
    /**
     * Thanks for guide action
     *   
     * @param Request $request
     * @return Response
     */        
    public function thanksAction(Request $request)
    {
        $user = $this->get("security.context")->getToken()->getUser();
        
        $user->setIsFirstTime(false);
        $user->save();
        
        return new \Symfony\Component\HttpFoundation\Response();
        
    }
   
}
