<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Service;

use Visualnet\UserBundle\Model\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Common service
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Service
 * @access public
 * @copyright visualnet.pl
 */
class Common
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Encode user value
     * 
     * @param mixed $value
     * @return mixed 
     */
    public function setUserToken(User $user)
    {
        return base64_encode(sha1($user->getEmail() . $user->getId()));
    }

    /**
     * Check user token value
     * 
     * @param User $user
     * @param string $token
     * @return boolean
     */
    public function checkUserToken(User $user, $token)
    {
        return (sha1($user->getEmail() . $user->getId()) == base64_decode($token)) ? true : false;
    }

    /**
     * Make regional locale
     * 
     * @param string $locale
     * @return string 
     */
    public function getRegionLocale($locale)
    {
        return $locale . "_" . strtoupper($locale);
    }

    /**
     * Check if user has specifed role
     * 
     * @param string $role 
     * @return boolean
     */
    public function isRoleExists($role)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $roles = $user->getRoles();

        return (in_array($role, $roles)) ? true : false;
    }

}
