<?php

namespace Visualnet\VisualRecruiter\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Visualnet\UserBundle\Model;
use Visualnet\VisualRecruiter\UserBundle\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Visualnet\VisualRecruiter\UtilsBundle\Helper;

/**
 * Default group controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class RoleController extends Controller
{

    /**
     * Show list
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN")
     * @param Request $request
     * @return mixed|html|json
     */
    public function listAction(Request $request)
    {
        
        $format = $request->getRequestFormat();
        
        // if isn`t ajax request generate default layout
        if(!$request->isXmlHttpRequest()){
            return $this->render("UserBundle:Role:index." . $format . ".twig");
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

        $roles = Model\RoleQuery::create();

        return $this->render("UserBundle:Role:index." . $request->getRequestFormat() . ".twig", array("config" => $this->get("utils_grid")->make($roles, $input)
                ));
    }

    /**
     * Show form for new data
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN")
     * @param Request $request
     * @return mixed 
     */
    public function newAction(Request $request)
    {
        $role = new Model\Role();
        $form = $this->createForm(new Form\Role(), $role);

        return $this->render("UserBundle:Role:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $role
                ));
    }

    /**
     * Add new data into database
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN")
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $role = new Model\Role();
        $form = $this->createForm(new Form\Role(), $role);

        return $this->process($request, $form, $role);
    }
    
    /**
     * Show populated form
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN")
     * @param Role $role
     * @param Request $request
     * @return mixed
     */
    public function editAction(Model\Role $role, Request $request)
    {
        $form = $this->createForm(new Form\Role(), $role);

        return $this->render("UserBundle:Role:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $role
                ));
    }

    /**
     * Edit data
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN")
     * @param Role $role
     * @param Request $request
     * @return mixed
     */
    public function updateAction(Model\Role $role, Request $request)
    {

        if ($request->get("sf_method") != "PUT") {
            throw $this->createNotFoundException("Zła metoda przesyłania formularza");
        }

        $form = $this->createForm(new Form\Role(), $role);
        
        return $this->process($request, $form, $role);
    }

    /**
     * Extra method to save data
     * 
     * @param Request $request
     * @param  $form
     * @param $object
     * @return application/json
     */
    private function process(Request $request, $form, $object)
    {
        $out = array();

        if ("POST" == $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {

                $object->save();

                $out["state"] = true;

                if ("PUT" == $request->get("sf_method")) {
                    $out["message"] = "Wyedytowano role";
                } else {
                    $out["message"] = "Dodano role";
                }
            } else {
                
                $out["state"] = false;
                $out["message"] = "Wystąpił błąd w formularzu";
                $out["errors"] = json_encode(Helper\String::getErrorMessages($form));
            }
        }

        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
