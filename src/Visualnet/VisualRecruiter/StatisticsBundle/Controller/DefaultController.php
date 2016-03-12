<?php

namespace Visualnet\VisualRecruiter\StatisticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default statistics controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\StatisticsBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class DefaultController extends Controller
{
    public function makeAction(Request $request) {
        
        
        
        
        return $this->render('StatisticsBundle:Default:index.html.twig');
        
    }

}
