<?php

namespace Visualnet\VisualRecruiter\UserBundle\Service;

use Visualnet\UserBundle\Model;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Role service
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Service
 * @access public
 * @copyright visualnet.pl
 */
class Role
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get roles by user
     * 
     * @param string $roleType
     * @return PropelCollection 
     */
    public function get($roleType = null)
    {
        $context = $this->container->get("security.context");
        $role = Model\RoleQuery::create();

        if (!$context->isGranted("ROLE_ADMIN") and is_null($roleType)) {

            return $role->filterByType(Model\RolePeer::TYPE_USER)->find();
        }

        return $role->find();
    }

}
