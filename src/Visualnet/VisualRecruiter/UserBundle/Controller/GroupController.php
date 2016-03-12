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
class GroupController extends Controller
{

    /**
     * Show list
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN, ROLE_USER_ADMINGROUP")
     * @param Request $request
     * @return mixed|html|json
     */
    public function listAction(Request $request)
    {
        
        $format = $request->getRequestFormat();
        
        // if isn`t ajax request generate default layout
        if(!$request->isXmlHttpRequest()){
            return $this->render("UserBundle:Group:index." . $format . ".twig");
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

        $context = $this->get("security.context");
        $roleExists = $context->isGranted("ROLE_ADMIN");

        $groups = Model\GroupQuery::create();

        if (!$roleExists) {

            $groups->join("UserGroup", \Criteria::LEFT_JOIN)
                    ->useUserGroupQuery()
                    ->filterByUserId($context->getToken()->getUser()->getId())
                    ->endUse();
        }

        return $this->render("UserBundle:Group:index." . $format . ".twig", array("config" => $this->get("utils_grid")->make($groups, $input)
                ));
    }

    /**
     * Show form for new data
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN, ROLE_USER_ADMINGROUP")
     * @param Request $request
     * @return mixed 
     */
    public function newAction(Request $request)
    {
        $group = new Model\Group();

        $form = $this->createForm(new Form\Group(), $group);

        return $this->render("UserBundle:Group:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $group
                ));
    }

    /**
     * Add new data into database
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN, ROLE_USER_ADMINGROUP")
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $group = new Model\Group();
        $form = $this->createForm(new Form\Group(), $group);

        return $this->process($request, $form, $group);
    }

    /**
     * Show populated form
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN, ROLE_USER_ADMINGROUP")
     * @param Group $group
     * @param Request $request
     * @return mixed
     */
    public function editAction(Model\Group $group, Request $request)
    {
        $form = $this->createForm(new Form\Group(), $group);

        return $this->render("UserBundle:Group:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $group
                ));
    }

    /**
     * Edit data
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN, ROLE_USER_ADMINGROUP")
     * @param Group $group
     * @param Request $request
     * @return mixed
     */
    public function updateAction(Model\Group $group, Request $request)
    {

        if ($request->get("sf_method") != "PUT") {
            throw $this->createNotFoundException("Zła metoda przesyłania formularza");
        }

        $form = $this->createForm(new Form\Group(), $group);

        return $this->process($request, $form, $group);
    }

    /**
     * Delete data
     *   
     * @Secure(roles="ROLE_ADMIN_GODMODE")
     * @param Request $request
     * @return RedirectResponse
     * @throws NotFoundHttpException 
     */
    public function deleteAction(Request $request)
    {
        $out = array();
        $group = Model\GroupQuery::create()->findPk($request->get("id"));

        if (!$group) {
            $out["state"] = false;
            $out["message"] = sprintf("Nie ma takiej grupy id: %s", $request->get("id"));
        }else{
            
            $group->delete();

            $out["state"] = true;
            $out["message"] = "Usunięto grupę";
            
        }

        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

        return $response;          
    }

    /**
     * Extra method to save data
     * 
     * @param Request $request
     * @param $form
     * @param $object
     * @return mixed
     */
    private function process(Request $request, $form)
    {
        $out = array();

        if ("POST" == $request->getMethod()) {

            $groupRolesData = $request->get("grouproles");
            $context = $this->get("security.context");
            $form->bindRequest($request);

            $group = $form->getData();

            if ($form->isValid()) {

                $group->save();

                $out["state"] = true;

                Model\GroupRoleQuery::create()->filterByGroupId($group->getId())->delete();

                if (!empty($groupRolesData)) {

                    $groupRole = new Model\GroupRole();
                    $groupRole->insertMulti($groupRolesData, $group->getId());
                }

                if ("PUT" == $request->get("sf_method")) {
                    $out["message"] = "Wyedytowano grupę";
                } else {

                    // add user to group
                    $userGroup = new Model\UserGroup();
                    $userGroup->setUserId($context->getToken()->getUser()->getId());
                    $userGroup->setGroupId($group->getId());
                    $userGroup->setIsGroupAdmin(true);

                    $userGroup->save();

                    $out["message"] = "Dodano grupę";
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
