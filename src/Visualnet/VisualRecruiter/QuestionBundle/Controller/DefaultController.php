<?php

namespace Visualnet\VisualRecruiter\QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Visualnet\VisualRecruiter\QuestionBundle\Model;
use Visualnet\VisualRecruiter\QuestionBundle\Form;
use Visualnet\VisualRecruiter\QuestionBundle\Helper;
use Visualnet\VisualRecruiter\UtilsBundle\Helper\String;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Default question controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\QuestionBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class DefaultController extends Controller
{
    
    /**
     * Show list
     * 
     * @param Request $request
     * @return mixed|html|json
     */
    public function listAction(Request $request)
    {
        $format = $request->getRequestFormat();
        
        // if isn`t ajax request generate default layout
        if(!$request->isXmlHttpRequest()){
            return $this->render("QuestionBundle:Default:index." . $format . ".twig");
        }            

        $limit = $this->container->getParameter("paginator_elements_per_site");
        $page = $request->get("page");

        $input = array(
            "limit" => $limit,
            "page" => $request->get("page"),
            "sidx" => $request->get("sidx"),
            "sord" => $request->get("sord"),
            "offset" => $limit * $page - $limit,
            "filters" => json_decode($request->get("filters"))
        );

        $questions = Model\QuestionQuery::create()->joinWithUser();

        $context = $this->get("security.context");
        $roleExists = $context->isGranted("ROLE_ADMIN");

        if (!$roleExists) {

            $questions->join("User", \Criteria::LEFT_JOIN)
                    ->useUserQuery()
                        ->filterById($context->getToken()->getUser()->getId())
                    ->endUse();
        }        
                
        return $this->render("QuestionBundle:Default:index." . $format . ".twig", 
                array("config" => $this->get("utils_grid")->make($questions, $input)
                ));
    }

    /**
     * Show form for new data
     * 
     * @param Request $request
     * @return mixed 
     */
    public function newAction(Request $request)
    {

        $question = new Model\Question();
        $form = $this->createForm(new Form\Question(Helper\Question::getRules($this->get("translator"))), $question);

        return $this->render("QuestionBundle:Default:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $question));
    }

    /**
     * Add new data into database
     * 
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $question = new Model\Question();
        $form = $this->createForm(new Form\Question(Helper\Question::getRules($this->get("translator"))), $question);

        return $this->process($request, $form, $question);
    }

    /**
     * Show populated form
     * 
     * @param Question $question
     * @param Request $request
     * @return mixed
     */
    public function editAction(Request $request)
    {
        $object = Model\QuestionQuery::create()->filterById($request->get("id"))->findOne();       
        $form = $this->createForm(new Form\Question(Helper\Question::getRules($this->get("translator"))), $object)->createView();

        return $this->render("QuestionBundle:Default:form.html.twig", compact("form", "object"));
    }    
    
    /**
     * Edit data
     * 
     * @param Question $question
     * @param Request $request
     * @return mixed
     */
    public function updateAction(Request $request)
    {

        if ($request->get("sf_method") != "PUT") {
            throw $this->createNotFoundException("Zła metoda przesyłania formularza");
        }
        
        $question = Model\QuestionQuery::create()->filterById($request->get("id"))->findOne(); 
        $form = $this->createForm(new Form\Question(Helper\Question::getRules($this->get("translator"))), $question);

        return $this->process($request, $form, $question);
    }    
    
    /**
     * Delete data
     *   
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_USER_ADMINGROUP")
     * @param Request $request
     * @return RedirectResponse
     * @throws NotFoundHttpException 
     */
    public function deleteAction(Request $request)
    {
        $out = array();
        $question = Model\QuestionQuery::create()->findOneById($request->get("id"));

        if (!$question) {
            $out["state"] = false;
            $out["message"] = sprintf("Nie ma takiego pytania id: %s", $request->get("id"));
        }else{
            
            $question->delete();

            $out["state"] = true;
            $out["message"] = "Usunięto pytanie";
            
        }

        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

        return $response;          
      
    }    
    
    
    
    /**
     * Search for question
     * 
     * @param Request $request
     * @return type 
     */
    public function searchAction(Request $request)
    {
        $questions = $this->container->get("user")->getQuestions()
                ->where(Model\QuestionPeer::NAME." LIKE ?", "%".$request->get("term")."%")
                ->find();  

        return $this->render("QuestionBundle:Default:search." . $request->getRequestFormat() . ".twig", compact("questions"));
    }  
    
    /**
     * Get user questions
     * 
     * @param Request $request
     * @return Response 
     */
    public function getAction(Request $request)
    {
        $questions = $this->container->get("user")->getQuestions()->find();
        $formID = $request->get("formID");
                
        return $this->render("QuestionBundle:Default:get.html.twig", compact("questions", "formID"));
    }
    
    /**
     * Extra method to save data
     * 
     * @param Request $request
     * @param  $form
     * @param $object
     * @return mixed
     */
    private function process(Request $request, $form, $object)
    {
        $out = array();
        
        if ("POST" === $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {

                $context = $this->container->get("security.context");
                
                // check security context for admin data
                if($context->isGranted("ROLE_ADMIN")){
                    
                    $object->setIsPredefined(true);
                    $object->setGroupId(1); // default group for admin
                    
                }else{
                    $object->setGroupId($context->getToken()->getUser()->getGroup()->getId());
                }
                
                $object->setUserId($context->getToken()->getUser()->getId());
                $object->save();
                
                $out["state"] = true;

                if ("PUT" == $request->get("sf_method")) {
                    $out["message"] = "Wyedytowano pytanie";
                } else {
                    $out["message"] = "Dodano pytanie";
                }

            } else {

                $out["state"] = false;
                $out["message"] = "Wystąpił błąd w formularzu";
                $out["errors"] = json_encode(String::getErrorMessages($form));
            }
        }
        
        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

        return $response;        
        
    }
   
}
