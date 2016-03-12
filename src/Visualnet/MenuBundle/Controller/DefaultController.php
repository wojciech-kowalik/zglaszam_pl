<?php

namespace Visualnet\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Visualnet\MenuBundle\Model;
use Visualnet\MenuBundle\Form;
use Visualnet\MenuBundle\Helper;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Visualnet\VisualRecruiter\UtilsBundle\Helper as UtilsHelper;

/**
 * Default menu controller
 * 
 * @author w.kowalik 
 * @package Visualnet\MenuBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class DefaultController extends Controller
{

    /**
     * Default action 
     * 
     * @Secure(roles="ROLE_ADMIN")
     * @return Response
     */
    public function listAction(Request $request)
    {
        $format = $request->getRequestFormat();
        
        // if isn`t ajax request generate default layout
        if(!$request->isXmlHttpRequest()){
            return $this->render("MenuBundle:Default:index." . $format . ".twig");
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
            "page" => $page,
            "sidx" => $sidx,
            "sord" => $sord,
            "offset" => $limit * $page - $limit,
            "filters" => json_decode($request->get("filters"))
        );

        $menu = Model\MenuQuery::create()->joinWithI18n();
                
        return $this->render("MenuBundle:Default:index." . $format . ".twig", 
                array("config" => $this->get("utils_grid")->make($menu, $input, "I18n")
                ));
    }

    /**
     * Change order on list elements
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response 
     */
    public function orderAction(Request $request)
    {

        $current = $request->get("current");
        $previous = $request->get("previous");

        if (!empty($previous)) {

            $elements = Model\MenuQuery::create()->findPks(array($current, $previous));
            $elements[1]->swapWith($elements[0]);
        }

        return new \Symfony\Component\HttpFoundation\Response();
    }

    /**
     * Show form for new data
     * 
     * @Secure(roles="ROLE_ADMIN")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $menu = new Model\Menu();

        $this->container->get("menu")->addTranslate($menu, $this->container);

        $form = $this->createForm(new Form\Menu(), $menu);

        return $this->render("MenuBundle:Default:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $menu
                ));
    }

    /**
     * Add new data into database
     * 
     * @Secure(roles="ROLE_ADMIN")
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {

        if ("POST" != $request->getMethod()) {
            throw $this->createNotFoundException("Zła metoda przesyłania formularza");
        }

        $menu = new Model\Menu();

        $this->container->get("menu")->addTranslate($menu, $this->container);

        $form = $this->createForm(new Form\Menu(), $menu);

        return $this->process($request, $form);
    }

    /**
     * Show populated form
     * 
     * @Secure(roles="ROLE_ADMIN")
     * @param Menu $menu
     * @param Request $request
     * @return mixed
     */
    public function editAction(Model\Menu $menu, Request $request)
    {
        $form = $this->createForm(new Form\Menu(), $menu);

        return $this->render("MenuBundle:Default:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $menu
                ));
    }

    /**
     * Edit data
     * 
     * @Secure(roles="ROLE_ADMIN")
     * @param Menu $menu
     * @param Request $request
     * @return mixed
     */
    public function updateAction(Model\Menu $menu, Request $request)
    {

        if ("PUT" != $request->get("sf_method")) {
            throw $this->createNotFoundException("Zła metoda przesyłania formularza");
        }

        $form = $this->createForm(new Form\Menu(), $menu);

        return $this->process($request, $form);
    }

    /**
     * Delete data
     *   
     * @Secure(roles="ROLE_ADMIN_GODMODE")
     * @param Request $request
     * @return appliaction/json
     */
    public function deleteAction(Request $request)
    {
        $out = array();
        $menu = Model\MenuQuery::create()->findPk($request->get("id"));

        if (!$menu) {
            $out["state"] = false;
            $out["message"] = sprintf("Nie ma takiego elementu id: %s", $request->get("id"));
        }else{
            
            $menu->delete();

            $out["state"] = true;
            $out["message"] = "Usunięto element";
            
        }

        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

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
    private function process(Request $request, $form)
    {
        $out = array();

        if ("POST" === $request->getMethod()) {

            $form->bindRequest($request);

            $menu = $form->getData();

            if ($form->isValid()) {

                $menu->save();

                $out["state"] = true;

                if ("PUT" == $request->get("sf_method")) {
                    $out["message"] = "Wyedytowano element menu";
                } else {
                    $out["message"] = "Dodano element menu";
                }
                
            } else {

                $out["state"] = false;
                $out["message"] = "Wystąpił błąd w formularzu";
                $out["errors"] = json_encode(UtilsHelper\String::getErrorMessages($form));
            }
        }

        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

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
        $direction = $request->get("direction");
        
        // set default change object
        $changeObject = new \stdClass();
        
        // get question data
        $menu = Model\MenuQuery::create()
                ->findOneById($questionID);
                
        // sort depends on direction 0 - up, 1 - down
        switch($direction){
            
            case 0: $changeObject = $menu->moveUp(); break;
            case 1: $changeObject = $menu->moveDown(); break;
        }
        
        // check if position of element was changed
        if($changeObject instanceof Model\Menu){
            
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
