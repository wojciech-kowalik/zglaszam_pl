<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model;
use Visualnet\VisualRecruiter\FormBundle\Model as FormModel;
use Visualnet\VisualRecruiter\RecruitmentBundle\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Visualnet\VisualRecruiter\UtilsBundle\Helper;
use Visualnet\VisualRecruiter\FrontendBundle\Controller as FrontendController;

/**
 * Recruitment user controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\RecruitmentBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class RecruitmentUserController extends Controller
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
        $recruitment = $this->container->get("session")->get("recruitment");
        $from = 0; // default 0 value - get recruitment users
        // get recruitment date id
        $recruitmentDateId = $request->get("id");

        // if recruitment date isset set new from value
        if ($recruitmentDateId) {
            $from = $recruitmentDateId;
        }

        if (!isset($recruitment) and empty($recruitment)) {
            return $this->createNotFoundException("Nie ma takiej rejestracji");
        }

        // if isn`t ajax request generate default layout
        if (!$request->isXmlHttpRequest()) {
            return $this->render("RecruitmentBundle:User:index." . $format . ".twig", array("from" => $from, "recruitmentDateId" => $recruitmentDateId));
        }

        $limit = $this->container->getParameter("paginator_elements_per_site");
        $page = $request->get("page");

        $sidx = $request->get("sidx");
        $sord = $request->get("sord");

        $input = array(
            "limit" => $limit,
            "page" => $request->get("page"),
            "sidx" => $sidx,
            "sord" => $sord,
            "offset" => $limit * $page - $limit,
            "filters" => json_decode($request->get("filters"))
        );

        $recruitmentUsers = Model\RecruitmentUserQuery::create();

        if ($recruitmentDateId) {
            $recruitmentUsers->filterByRecruitmentDateId($recruitmentDateId);
        } else {
            $recruitmentUsers->filterByRecruitmentId($recruitment["Id"]);
        }

        return $this->render("RecruitmentBundle:User:index." . $format . ".twig", array("config" => $this->get("utils_grid")->make($recruitmentUsers, $input)
                ));
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

        return $this->render("RecruitmentBundle:Default:dateform.html.twig", array(
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
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_USER_ADMINGROUP")
     * @param Request $request
     * @return RedirectResponse
     * @throws NotFoundHttpException 
     */
    public function deleteAction(Request $request)
    {
        $out = array();
        $user = Model\RecruitmentUserQuery::create()->findOneById($request->get("id"));

        if (!$user) {
            $out["state"] = false;
            $out["message"] = sprintf("Nie ma takiego uczestnika id: %s", $request->get("id"));
        } else {

            // decrement used limit value
            $recruitmentDataEntity = Model\RecruitmentDateQuery::create()->findOneById($user->getRecruitmentDateId());
            $recruitmentDataEntity->setUsedLimit($recruitmentDataEntity->getUsedLimit() - 1);
            $recruitmentDataEntity->save();

            $user->delete();

            $out["state"] = true;
            $out["message"] = "Usunięto uczestnika";
        }

        $response = new Response(json_encode($out));
        $response->headers->set("Content-Type", "application/json");

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
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }

    /**
     * Qualify users to recruitment date
     * 
     * @param Request $request
     */
    public function qualifyAction(Request $request)
    {

        $qualified = $request->get("qualified");
        $out = array();

        try {

            $recruitmentUsers = Model\RecruitmentUserQuery::create()
                    ->filterByPrimaryKeys($qualified)
                    ->update(array("IsQualify" => 1));

            $out["state"] = true;
            $out["message"] = $this->get("translator")->trans($recruitmentUsers . " uczestnik(ów) został(o) kwalifikowany(ch)");
        } catch (\Exception $e) {

            $out["state"] = false;
            $out["message"] = $e->getMessage();
        }

        $response = new Response(json_encode($out));
        $response->headers->set("Content-Type", "application/json");

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
    public function showAction(Request $request)
    {

        $userId = $request->get("id");

        $recruitmentUser = Model\RecruitmentUserQuery::create()
                ->findOneById($userId);

        $recruitmentUsersData = Model\RecruitmentUserDataQuery::create()
                ->joinWith("Question")
                ->filterByUserRecruitmentId($userId)
                ->find();

        return $this->render("RecruitmentBundle:User:show.html.twig", array(
                    "recruitmentUsersData" => $recruitmentUsersData,
                    "recruitmentUser" => $recruitmentUser
                ));
    }

    /**
     * Export users list
     * 
     * @param $request Request
     * @param $type string
     * @param $form string
     * @return Response
     */
    public function exportAction(Request $request, $type, $from)
    {
        $recruitment = $this->get("session")->get("recruitment");
        $recruitmentUsersData = $questionsToExport = $data = array();

// ---------------------------------------
// 1 phase - get users
// ---------------------------------------

        // get users from recruitment or recruitment date
        if (0 != $from) {
            $recruitmentUsersData = Model\RecruitmentUserQuery::create()
                    ->joinWithRecruitmentUserData()->select(array("Id", "Name", "Surname", "Email", "RecruitmentUserData.QuestionId", "RecruitmentUserData.Value"))
                    ->filterByRecruitmentDateId($from)
                    ->find()
                    ->toArray();
        } else {
            $recruitmentUsersData = Model\RecruitmentUserQuery::create()
                    ->joinWithRecruitmentUserData()->select(array("Id", "Name", "Surname", "Email", "RecruitmentUserData.QuestionId", "RecruitmentUserData.Value"))
                    ->filterByRecruitmentId($recruitment["Id"])
                    ->find()
                    ->toArray();
        }

// ---------------------------------------
// 2 phase - get questions to export
// ---------------------------------------
        
        // get default users fields
        $defaultExportFields = FrontendController\RecruitmentController::$defaultFields;

        // data mapping
        foreach ($defaultExportFields as $name => $defaultExportField) {

            if($defaultExportField["export"] === false){
                continue;
            }
            
            $defaultQuestion = array(
                "Question.Name" => $defaultExportField["translate"],
                "FormQuestion.ExportName" => $name,
                "FormQuestion.QuestionId" => ucfirst($name)
            );

            array_push($questionsToExport, $defaultQuestion);
        }

        unset($defaultExportFields);

        // get questions with is_export flag from form recruitment
        $questions = Model\RecruitmentQuery::create()
                        ->select(array("FormQuestion.QuestionId", "Question.Name", "FormQuestion.ExportName"))
                        ->joinWithForm()
                        ->filterById($recruitment["Id"])
                        ->add(FormModel\FormQuestionPeer::IS_EXPORT, true, \Criteria::EQUAL)
                        ->join("Form.FormQuestion")
                        ->join("FormQuestion.Question")
                        ->orderBy("Question.Id")
                        ->find()->toArray();

        $questionsToExport = array_merge($questionsToExport, $questions);

        unset($questions);
        
// ---------------------------------------
// 3 phase - prepare data
// ---------------------------------------        

        // iterate over questions to export
        foreach ($questionsToExport as $question) {

            // set export headers
            if ($question["FormQuestion.ExportName"]) {
                $data["headers"][] = $question["FormQuestion.ExportName"];
            } else {
                $data["headers"][] = $question["Question.Name"];
            }

            // iterate over users data
            foreach ($recruitmentUsersData as $recruitmentUserData) {

                // if there is dynamic question value
                if (($recruitmentUserData["RecruitmentUserData.QuestionId"] == $question["FormQuestion.QuestionId"])) {

                    $data["data"][$recruitmentUserData["Id"]][$question["FormQuestion.QuestionId"]]
                            = $recruitmentUserData["RecruitmentUserData.Value"];
                }

                // if there is default question value
                if (is_string($question["FormQuestion.QuestionId"])
                        && isset($recruitmentUserData[$question["FormQuestion.QuestionId"]])) {

                    $data["data"][$recruitmentUserData["Id"]][$question["FormQuestion.QuestionId"]]
                            = $recruitmentUserData[$question["FormQuestion.QuestionId"]];
                }
            }
        }
        
// ---------------------------------------
// 4 phase - forward data into separate 
//           strategy action
// ---------------------------------------        

        return $this->forward('ExportBundle:Default:make', array(
                    "export" => $data,
                    "type" => $type));
    }

}
