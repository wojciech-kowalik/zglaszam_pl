<?php

namespace Visualnet\VisualRecruiter\UserBundle\Service;

use Visualnet\UserBundle\Model;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Group service
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Service
 * @access public
 * @copyright visualnet.pl
 */
class Group
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get groups where user is owner
     * 
     * @return PropelCollection 
     */
    public function get()
    {
        $context = $this->container->get("security.context");
        $user = $context->getToken()->getUser();

        $userGroup = Model\UserGroupQuery::create();

        if ($context->isGranted("ROLE_ADMIN")) {

            return $userGroup
                            ->joinGroup()
                            ->with("Group")
                            ->filterByIsGroupAdmin(true)
                            ->groupByGroupId()
                            ->find();
        }

        return $userGroup
                        ->joinGroup()
                        ->with("Group")
                        ->filterByUserId($user->getId())
                        ->filterByIsGroupAdmin(true)
                        ->groupByGroupId()
                        ->find();
    }

}
