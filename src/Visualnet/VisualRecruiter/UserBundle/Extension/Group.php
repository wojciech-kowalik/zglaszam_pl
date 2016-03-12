<?php

namespace Visualnet\VisualRecruiter\UserBundle\Extension;

use Visualnet\VisualRecruiter\UserBundle\Service;

/**
 * Group twig extension
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Extension
 * @access public
 * @copyright visualnet.pl
 */
class Group extends \Twig_Extension
{

    protected $group;

    function __construct(Service\Group $group)
    {
        $this->group = $group;
    }

    public function getGlobals()
    {
        return array(
            'group' => $this->group
        );
    }

    public function getName()
    {
        return 'group';
    }

}