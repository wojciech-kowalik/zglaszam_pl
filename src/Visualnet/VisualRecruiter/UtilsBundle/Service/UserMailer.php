<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Service;

use Symfony\Component\Templating\EngineInterface;
use Visualnet\UserBundle\Model\User;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUser;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDate;

/**
 * UserMailer service
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Service
 * @access public
 * @copyright visualnet.pl
 */
class UserMailer
{

    protected $mailer;
    protected $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * Send register mail to user
     * 
     * @param User $user 
     */
    public function register(User $user)
    {

        $message = \Swift_Message::newInstance()
                ->setSubject("Rejestracja w zglaszam.pl")
                ->setFrom(array("noreply@zglaszam.pl" => "System zglaszam.pl"))
                ->setTo($user->getEmail())
                ->setBody($this->templating->render("UserBundle:Register:email.html.twig", array("user" => $user)), "text/html");

        $this->mailer->send($message);
    }

    /**
     * Send mail to new registered user
     * 
     * @param User $user 
     */
    public function create(User $user)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject("Nowy użytkownik w zglaszam.pl")
                ->setFrom(array("noreply@zglaszam.pl" => "System zglaszam.pl"))
                ->setTo($user->getEmail())
                ->setBody($this->templating->render("UserBundle:User:email.html.twig", array("user" => $user)), "text/html");

        $this->mailer->send($message);
    }
    
    /**
     * Send mail to user recritment
     * 
     * @param User $user 
     */
    public function recruitmentRegister(RecruitmentUser $user, RecruitmentDate $date)
    {
                
        $message = \Swift_Message::newInstance()
                ->setSubject("Rejestracja w zglaszam.pl")
                ->setFrom(array("noreply@zglaszam.pl" => "System zglaszam.pl"))
                ->setTo($user->getEmail())
                ->setBody($this->templating->render("RecruitmentBundle:User:email.html.twig", array("user" => $user, "date" => $date)), "text/html");

        $this->mailer->send($message);
    } 
    
    /**
     * Send mail with new password to user
     * 
     * @param User $user 
     */    
    public function remindPassword(User $user){
        
        $message = \Swift_Message::newInstance()
                ->setSubject("Nowe hasło w systemie zglaszam.pl")
                ->setFrom(array("noreply@zglaszam.pl" => "System zglaszam.pl"))
                ->setTo($user->getEmail())
                ->setBody($this->templating->render("UserBundle:Password:email.html.twig", array("user" => $user)), "text/html");

        $this->mailer->send($message);        
        
    }
    
    /**
     * Send suggest to administrator
     * 
     * @param User $user
     * @param array $data 
     */    
    public function sendSuggest($user, array $data){
        
        $message = \Swift_Message::newInstance()
                ->setSubject("Sugestia od użytkownika zglaszam.pl")
                ->setFrom(array("noreply@zglaszam.pl" => "System zglaszam.pl"))
                ->setTo($data["administratorEmail"])
                ->setBody($this->templating->render("UserBundle:Suggest:email.html.twig", array("user" => $user, "data" => $data)), "text/html");

        $this->mailer->send($message);        
        
    }

}
