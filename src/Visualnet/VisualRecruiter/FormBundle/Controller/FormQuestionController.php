<?php

namespace Visualnet\VisualRecruiter\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Visualnet\VisualRecruiter\FormBundle\Model;
use Visualnet\VisualRecruiter\FormBundle\Form;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Visualnet\VisualRecruiter\UtilsBundle\Helper;

/**
 * Form question controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\FormBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class FormQuestionController extends Controller
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
        $formID = $request->get("id");

        // if isn`t ajax request generate default layout
        if (!$request->isXmlHttpRequest()) {
            return $this->render("FormBundle:Default:questions." . $format . ".twig", array("formID" => $formID));
        }

        $limit = $this->container->getParameter("paginator_elements_per_site");
        $page = $request->get("page");

        $sidx = $request->get("sidx");
        $sord = $request->get("sord");

        if (empty($sidx)) {

            $sidx = "SortableRank";
            $sord = "asc";
        }

        $input = array(
            "limit" => $limit,
            "page" => $request->get("page"),
            "sidx" => $sidx,
            "sord" => $sord,
            "offset" => $limit * $page - $limit,
            "filters" => json_decode($request->get("filters"))
        );

        $questions = Model\FormQuestionQuery::create()
                ->filterByFormId($formID)
                ->joinWithQuestion();

        return $this->render("FormBundle:Default:questions." . $format . ".twig", array(
            "formID" => $formID, 
            "config" => $this->get("utils_grid")->make($questions, $input, "Question")
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

        $questionID = $request->get("id");
        $formID = $request->get("mainID");

        $questionLabel = null;

        $question = \Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionQuery::create()
                        ->findOneById($questionID);

        $formQuestion = new Model\FormQuestion();
        $formQuestion->setLabel($question->getLabel());
        $formQuestion->type = $question->getType();

        $form = $this->createForm(new Form\FormQuestion(), $formQuestion);

        return $this->render("FormBundle:Default:questionform.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $formQuestion,
                    "id" => $questionID,
                    "mainID" => $formID
                ));
    }

    /**
     * Add new data into database
     * 
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $formQuestion = new Model\FormQuestion();
        $form = $this->createForm(new Form\FormQuestion(), $formQuestion);

        return $this->process($request, $form, $formQuestion);
    }

    /**
     * Show populated form
     * 
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request)
    {
        $questionID = $request->get("id");
        $formID = $request->get("mainID");

        $object = Model\FormQuestionQuery::create()
                ->joinWithQuestion()
                ->filterByQuestionId($questionID)
                ->filterByFormId($formID)
                ->findOne();
        
        $object->type = $object->getQuestion()->getType();
        $form = $this->createForm(new Form\FormQuestion(), $object);

        return $this->render("FormBundle:Default:questionform.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $object,
                    "id" => $questionID,
                    "mainID" => $formID
                ));
    }
    
    /**
     * Edit data
     * 
     * @param Form $form
     * @param Request $request
     * @return mixed
     */
    public function updateAction(Request $request)
    {

        if ($request->get("sf_method") != "PUT") {
            throw $this->createNotFoundException("Zła metoda przesyłania formularza");
        }

        $questionID = $request->get("id");
        $formID = $request->get("mainID");        
        
        $object = Model\FormQuestionQuery::create()
                ->joinWithQuestion()
                ->filterByQuestionId($questionID)
                ->filterByFormId($formID)
                ->findOne();
        
        $object->type = $object->getQuestion()->getType();
        $form = $this->createForm(new Form\FormQuestion(), $object);

        return $this->process($request, $form, $object);
    }    
    
    /**
     * Delete data
     *   
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $out = array();
        
        $questionID = $request->get("id");
        $formID = $request->get("mainID");           
        
        $formQuestion = Model\FormQuestionQuery::create()
                ->filterByQuestionId($questionID)
                ->filterByFormId($formID)
                ->findOne();

        if (!$formQuestion) {
            $out["state"] = false;
            $out["message"] = sprintf("Nie ma takiego pytania w formularzu id: %s", $questionID);
        } else {

            $formQuestion->delete();

            $out["state"] = true;
            $out["message"] = "Usunięto pytanie z formularza";
        }

        $response = new Response(json_encode($out));
        $response->headers->set("Content-Type", "application/json");

        return $response;
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

            $questionID = $request->get("id");
            $formID = $request->get("mainID");

            $form->bindRequest($request);

            if ($form->isValid()) {


                $object->setFormId($formID);
                $object->setQuestionId($questionID);

                $object->save();

                $out["state"] = true;

                if ("PUT" == $request->get("sf_method")) {
                    $out["message"] = $this->get("translator")->trans("Wyedytowano pytanie formularza");
                } else {
                    $out["message"] = $this->get("translator")->trans("Dodano pytanie do formularza");
                }
            } else {

                $out["state"] = false;
                $out["message"] = $this->get("translator")->trans("Wystąpił błąd w formularzu");
                $out["errors"] = json_encode(Helper\String::getErrorMessages($form));
            }
        }

        $response = new Response(json_encode($out));
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }

    /**
     * Check if form has already question
     * 
     * @param Request $request
     * @return Response
     */
    public function existsAction(Request $request)
    {

        $out = array();
        $questionID = $request->get("id");
        $formID = $request->get("mainID");

        $formQuestion = Model\FormQuestionQuery::create()
                ->filterByFormId($formID)
                ->filterByQuestionId($questionID)
                ->findOne();

        if ($formQuestion) {

            $out["state"] = false;
            $out["message"] = $this->get("translator")->trans("To pytanie istnieje już w formularzu");
        } else {
            $out["state"] = true;
        }

        $response = new Response(json_encode($out));
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }
    
    /**
     * Sort element action
     * 
     * @param Request $request
     * @return Response
     */    
    public function sortAction(Request $request)
    {
        $questionID = $request->get("id");
        $formID = $request->get("mainID");
        $direction = $request->get("direction");
        
        // set default change object
        $changeObject = new \stdClass();
        
        // get question data
        $formQuestion = Model\FormQuestionQuery::create()
                ->filterByFormId($formID)
                ->findOneByQuestionId($questionID);
                
        // sort depends on direction 0 - up, 1 - down
        switch($direction){
            
            case 0: $changeObject = $formQuestion->moveUp(); break;
            case 1: $changeObject = $formQuestion->moveDown(); break;
        }
        
        // check if position of element was changed
        if($changeObject instanceof Model\FormQuestion){
            
            $out["state"] = true;
            $out["message"] = $this->get("translator")->trans("Zmieniono pozycję elementu");
            
        }else{
            
            $out["state"] = false;
            $out["message"] = $this->get("translator")->trans("Wystąpił błąd podczas sortowania");
        }

        // make json response
        $response = new Response(json_encode($out));
        $response->headers->set("Content-Type", "application/json");

        return $response;
        
    }

}
