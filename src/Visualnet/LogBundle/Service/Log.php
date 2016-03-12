<?php

namespace Visualnet\LogBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Visualnet\UserBundle\Model\User;
use Visualnet\LogBundle\Model\Log as ModelLog;
use Visualnet\LogBundle\Enum\Type;
use Visualnet\LogBundle\Extras\LogContent;
use Symfony\Component\HttpFoundation\Request;

/**
 * Log service
 * 
 * @author w.kowalik 
 * @package Visualnet\LogBundle\Service
 * @access public
 * @copyright visualnet.pl
 */
class Log
{
    protected $container;

    /**
     * Default constructor
     * 
     * @param ContainerInterface $container 
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Log system data
     * 
     * @param mixed $user
     * @param Enum\Type $type
     * @return boolean 
     */
    public function save(Request $request, LogContent $content)
    {
        $token = $this->container->get("security.context")->getToken();
        $user = new User();
        
        if(is_null($token)){
            $user->setId(-1);
        }else{
            $user->setId($token->getUser()->getId());
        }
        
        \PHPUnit_Framework_Assert::assertTrue(is_numeric($user->getId()));
                
        $log = new ModelLog(); 
        $log->setUserId($user->getId());
        $log->setMesssage($content->message);
        $log->setIp($request->getClientIp());
        $log->setType($content->type);
        $log->save();
        
        return true;
    }

}
