<?php

namespace Visualnet\VisualRecruiter\UserBundle\Extension;

use Visualnet\VisualRecruiter\UserBundle\Service;

/**
 * Role twig extension
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Extension
 * @access public
 * @copyright visualnet.pl
 */
class Role extends \Twig_Extension
{

    protected $role;

    function __construct(Service\Role $role)
    {
        $this->role = $role;
    }

    public function getGlobals()
    {
        return array(
            'role' => $this->role
        );
    }

    public function getName()
    {
        return 'role';
    }

}