<?php

namespace Visualnet\VisualRecruiter\UserBundle\Service;

use Visualnet\UserBundle\Model;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * User service
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Service
 * @access public
 * @copyright visualnet.pl
 */
class User
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get questions for users
     * 
     * @return QuestionModelCollection
     */
    public function getQuestions()
    {
        $context = $this->container->get("security.context");
        $user = $context->getToken()->getUser();
        $iterator = $user->getUserGroups()->getIterator();
        $groupsID = array();

        $question = \Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionQuery::create();
        
        if($context->isGranted("ROLE_ADMIN")){
            return $question;
        }
        
        // iterate on user groups collections
        while ($iterator->valid()) {

            array_push($groupsID, $iterator->current()->getGroupId());
            $iterator->next();
        }

        // get questions
        $question->filterByIsPredefined(true);

        if (empty($groupsID)) {

            return $question;
            
        } else {

            return $question->orWhere(\Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionPeer::GROUP_ID . " IN (" . implode(",", $groupsID) . ")");
        }
    }
    
    /**
     * Get forms for users
     * 
     * @return FormsModelCollection
     */
    public function getForms()
    {
        $context = $this->container->get("security.context");
        $user = $context->getToken()->getUser();
        $iterator = $user->getUserGroups()->getIterator();
        $groupsID = array();

        $form = \Visualnet\VisualRecruiter\FormBundle\Model\FormQuery::create()->filterByIsActive(true);
        
        if($context->isGranted("ROLE_ADMIN")){
            return $form;
        }
        
        // iterate on user groups collections
        while ($iterator->valid()) {

            array_push($groupsID, $iterator->current()->getGroupId());
            $iterator->next();
        }


        if (empty($groupsID)) {

            return $form;
            
        } else {

            return $form->where(\Visualnet\VisualRecruiter\FormBundle\Model\FormPeer::GROUP_ID . " IN (" . implode(",", $groupsID) . ")");
        }
    }   
    
    /**
     * Get recruitments for users
     * 
     * @return RecruitmentModelCollection
     */    
    public function getRecruitments(){
        
        $context = $this->container->get("security.context");
        $user = $context->getToken()->getUser();
        $iterator = $user->getUserGroups()->getIterator();
        $groupsID = array();
        
        $recruitment = \Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentQuery::create();
        
        if($context->isGranted("ROLE_ADMIN")){
            return $recruitment;
        }  
        
        // iterate on user groups collections
        while ($iterator->valid()) {

            array_push($groupsID, $iterator->current()->getGroupId());
            $iterator->next();
        }

        if (empty($groupsID)) {

            return $recruitment;
            
        } else {

            return $recruitment->where(\Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentPeer::GROUP_ID . " IN (" . implode(",", $groupsID) . ")");
        }        
        
    }

}
