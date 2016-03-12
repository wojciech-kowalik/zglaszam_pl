<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default utils controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class DefaultController extends Controller
{

    public function indexAction($name)
    {
        return $this->render('UtilsBundle:Default:index.html.twig', array('name' => $name));
    }

}
