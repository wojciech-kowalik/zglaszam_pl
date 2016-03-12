<?php

namespace Visualnet\VisualRecruiter\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Suggest controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\AdminBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class SuggestController extends Controller
{

    /**
     * Default action
     *   
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('AdminBundle:Suggest:index.html.twig');
    }
    
    /**
     * Send suggest action
     *   
     * @param Request $request
     * @return Response
     */    
    public function sendAction(Request $request)
    {
        $suggestContent = $request->get("content-suggest");
        
        // check if user send suggest
        if(empty($suggestContent)) {
            
            $out["state"] = false;      
            $out["message"] = "Wystąpił błąd w formularzu";
            $out["errors"] = json_encode(array("content-suggest" => "Pole wymagane"));
            
        }else{
            
            $administratorEmail = $this->container->getParameter("administrator_email");
            
            $data = array(
              
                "administratorEmail" => $administratorEmail,
                "suggest" => $suggestContent
            );
            
            // send email with suggest
            $this->get("utils_user_mailer")->sendSuggest($this->container->get("security.context")->getToken()->getUser(), $data);
            
            $out["state"] = true;
            $out["message"] = $this->get("translator")->trans("Wysłano pytanie/sugestię");             
        }       
        
        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

        return $response;          
    }


}
