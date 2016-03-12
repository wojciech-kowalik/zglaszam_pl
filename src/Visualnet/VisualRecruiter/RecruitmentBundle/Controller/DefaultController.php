<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model;
use Visualnet\VisualRecruiter\RecruitmentBundle\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Visualnet\VisualRecruiter\UtilsBundle\Helper;

/**
 * Default recruitment controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\RecruitmentBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class DefaultController extends Controller
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
        if (!$request->isXmlHttpRequest()) {
            return $this->render("RecruitmentBundle:Default:index." . $format . ".twig");
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

        $recruitments = Model\RecruitmentQuery::create();

        if (!$roleExists) {

            $recruitments->join("Group", \Criteria::LEFT_JOIN)
                    ->join("Group.UserGroup", \Criteria::LEFT_JOIN)
                    ->where('UserGroup.UserId = ?', $context->getToken()->getUser()->getId())
                    ->find();
        }

        return $this->render("RecruitmentBundle:Default:index." . $format . ".twig", array("config" => $this->get("utils_grid")->make($recruitments, $input)
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
        $recruitment = new Model\Recruitment();

        $form = $this->createForm(new Form\Recruitment(), $recruitment);

        return $this->render("RecruitmentBundle:Default:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $recruitment
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
        $recruitment = new Model\Recruitment();
        $form = $this->createForm(new Form\Recruitment(), $recruitment);

        return $this->process($request, $form, $recruitment);
    }

    /**
     * Show populated form
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN, ROLE_USER_ADMINGROUP")
     * @param Group $group
     * @param Request $request
     * @return mixed
     */
    public function editAction(Model\Recruitment $recruitment, Request $request)
    {

        $form = $this->createForm(new Form\Recruitment(), $recruitment);

        return $this->render("RecruitmentBundle:Default:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $recruitment
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
    public function updateAction(Model\Recruitment $recruitment, Request $request)
    {

        if ($request->get("sf_method") != "PUT") {
            throw $this->createNotFoundException("Zła metoda przesyłania formularza");
        }

        $form = $this->createForm(new Form\Recruitment(), $recruitment);

        return $this->process($request, $form, $recruitment);
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
        $recruitment = Model\RecruitmentQuery::create()->findById($request->get("id"));

        if (!$recruitment) {
            $out["state"] = false;
            $out["message"] = sprintf("Nie ma takiej rejestracji id: %s", $request->get("id"));
        } else {

            $recruitment->delete();

            $out["state"] = true;
            $out["message"] = "Usunięto rejestrację";
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

            $context = $this->get("security.context");
            $form->bindRequest($request);

            $recruitment = $form->getData();

            if ($form->isValid()) {

                $recruitment->setUserId($context->getToken()->getUser()->getId());

                // check security context for admin data
                if ($context->isGranted("ROLE_ADMIN")) {

                    $recruitment->setGroupId(1); // default group for admin
                } else {
                    $recruitment->setGroupId($context->getToken()->getUser()->getGroup()->getId());
                }

                $recruitment->setFormId($request->get("recruitment_form"));
                $recruitment->save();

                $out["state"] = true;

                if ("PUT" == $request->get("sf_method")) {
                    $out["message"] = "Wyedytowano rejestrację";
                } else {
                    $out["message"] = "Dodano rejestrację";
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
    
    /**
     * Get recruitments
     * 
     * @param Request $request
     * @return Response 
     */
    public function getAction(Request $request)
    {
        $recruitments = $this->container->get("user")->getRecruitments()->find();
     
        return $this->render("RecruitmentBundle:Default:get.html.twig", compact("recruitments"));
    }      

}
