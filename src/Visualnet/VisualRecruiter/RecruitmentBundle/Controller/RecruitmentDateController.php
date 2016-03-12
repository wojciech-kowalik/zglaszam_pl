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
 * Recruitment date controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\RecruitmentBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class RecruitmentDateController extends Controller
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
        $recruitmentID = $request->get("id");

        // if isn`t ajax request generate default layout
        if (!$request->isXmlHttpRequest()) {
            return $this->render("RecruitmentBundle:Date:index." . $format . ".twig", array("recruitmentID" => $recruitmentID));
        }

        $limit = $this->container->getParameter("paginator_elements_per_site");
        $page = $request->get("page");

        $sidx = $request->get("sidx");
        $sord = $request->get("sord");

        if (empty($sidx)) {

            $sidx = "CreatedAt";
            $sord = "desc";
        }

        $input = array(
            "limit" => $limit,
            "page" => $request->get("page"),
            "sidx" => $sidx,
            "sord" => $sord,
            "offset" => $limit * $page - $limit,
            "filters" => json_decode($request->get("filters"))
        );

        $dates = Model\RecruitmentDateQuery::create()
                ->filterByRecruitmentId($recruitmentID);

        return $this->render("RecruitmentBundle:Date:index." . $format . ".twig", array("recruitmentID" => $recruitmentID, "config" => $this->get("utils_grid")->make($dates, $input)
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
        $recruitmentDate = new Model\RecruitmentDate();
        $recruitmentID = $request->get("mainID");

        $form = $this->createForm(new Form\RecruitmentDate(), $recruitmentDate);

        return $this->render("RecruitmentBundle:Date:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $recruitmentDate,
                    "mainID" => $recruitmentID
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
        $recruitmentDate = new Model\RecruitmentDate();
        $form = $this->createForm(new Form\RecruitmentDate(), $recruitmentDate);

        return $this->process($request, $form, $recruitmentDate);
    }

    /**
     * Show populated form
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN, ROLE_USER_ADMINGROUP")
     * @param Group $group
     * @param Request $request
     * @return mixed
     */
    public function editAction(Model\RecruitmentDate $recruitmentDate, Request $request)
    {
        $form = $this->createForm(new Form\RecruitmentDate(), $recruitmentDate);
        $recruitmentID = $request->get("mainID");
        
        return $this->render("RecruitmentBundle:Date:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $recruitmentDate,
                    "mainID" => $recruitmentID
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
    public function updateAction(Model\RecruitmentDate $recruitmentDate, Request $request)
    {

        if ($request->get("sf_method") != "PUT") {
            throw $this->createNotFoundException("Zła metoda przesyłania formularza");
        }
       
        $form = $this->createForm(new Form\RecruitmentDate(), $recruitmentDate);

        return $this->process($request, $form, $recruitmentDate);
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
        $recruitment = Model\RecruitmentDateQuery::create()->findById($request->get("id"));

        if (!$recruitment) {
            $out["state"] = false;
            $out["message"] = sprintf("Nie ma takiej rejestracji id: %s", $request->get("id"));
        } else {

            $recruitment->delete();

            $out["state"] = true;
            $out["message"] = "Usunięto termin rejestracji";
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

            $form->bindRequest($request);

            $recruitmentID = $request->get("mainID");
            
            $recruitment = $form->getData();

            if ($form->isValid()) {

                $recruitment->setRecruitmentId($recruitmentID);
                $recruitment->save();

                $out["state"] = true;

                if ("PUT" == $request->get("sf_method")) {
                    $out["message"] = "Wyedytowano termin rejestracji";
                } else {
                    $out["message"] = "Dodano termin rejestracji";
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
     * Get recruitments dates
     * 
     * @param Request $request
     * @return Response 
     */
    public function getAction(Request $request)
    {
        $recruitment = $this->container->get("session")->get("recruitment");
        $recruitmentDateId = $request->get("recruitmentDateId");
        
        $dates = Model\RecruitmentDateQuery::create()
                ->findByRecruitmentId($recruitment["Id"]);
     
        return $this->render("RecruitmentBundle:Date:get.html.twig", compact("dates","recruitmentDateId"));
    }      

}
