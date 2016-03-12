<?php

namespace Visualnet\VisualRecruiter\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Visualnet\UserBundle\Model as UserModel;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model as RecruitmentModel;
use Visualnet\VisualRecruiter\FormBundle\Model as FormModel;
use Symfony\Component\HttpFoundation\Response;
use Visualnet\VisualRecruiter\UtilsBundle\Helper;
use Visualnet\VisualRecruiter\QuestionBundle\Helper as QuestionHelper;
use Visualnet\VisualRecruiter\RecruitmentBundle\Helper as RecruitmentHelper;

/**
 * Recruitment frontend controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\FrontendBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class RecruitmentController extends Controller
{

    /**
     * Set predefinded validators
     * @var array 
     */
    private $predefinedValidators;


    /**
     * Default constructor 
     */
    public function __construct()
    {
        $this->predefinedValidators = \Visualnet\VisualRecruiter\QuestionBundle\Helper\Question::getPredefinedValidators();
    }
    
    /**
     * Get recruitments from group
     * 
     * @param Request $request
     * @return Response 
     */
    public function groupAction(Request $request, $id)
    {
        $activeRecruitmentsIds = array();
        $recruitments = array();

        // get group name
        $groupName = UserModel\GroupQuery::create()
                ->select(array('Name'))
                ->findPk($id);
                
        // get active recruitment
        $activeRecruitments = UserModel\GroupQuery::create()
                ->select(array('Recruitment.Id'))
                ->joinWith('Recruitment')
                ->useRecruitmentQuery()
                ->filterByIsActive(true)
                ->endUse()
                ->filterById($id)
                ->find();

        // get active recruitments ids
        $activeRecruitmentsIds = $activeRecruitments->toArray();

        // check if active recruitment exists
        if (!empty($activeRecruitmentsIds)) {

            $in = RecruitmentModel\RecruitmentPeer::ID . ' IN (' . implode(',', $activeRecruitmentsIds) . ')';

            // get active recruitment and their dates
            $recruitments = RecruitmentModel\RecruitmentQuery::create()
                    ->joinWith('RecruitmentDate')
                    ->add(RecruitmentModel\RecruitmentPeer::ID, $in, \Criteria::CUSTOM)
                    ->find();
        }

        return $this->render('FrontendBundle:Recruitment:group.html.twig', compact('recruitments','groupName'));
    }

    /**
     * Show recruitment form
     * 
     * @param Request $request
     * @param string $aliasName
     * @return Response 
     */
    public function showAction(Request $request, $aliasName, $recruitmentDateId)
    {
        $toSerialize = $dataIds = $recruitmentDate = array();
        $validate = null;

        $recruitmentDate = RecruitmentModel\RecruitmentDateQuery::create()
                ->findOneById($recruitmentDateId);
        
        if($recruitmentDate == null){
            throw $this->createNotFoundException('Not found recruitment');
        }
        
        // check if recruitment date is active
        if ($recruitmentDate->getIsActive() == false) {
            throw $this->createNotFoundException('Recruitment date isn`t active');
        }

        // get actual recruitment
        $recruitment = RecruitmentModel\RecruitmentQuery::create()
                ->select(array('Id', 'Form.Id', 'Name', 'AliasName', 'Place'))
                ->joinWithForm()
                ->filterByAliasName($aliasName)
                ->findOne();


        // get temporary ids
        $dataIds['recruitmentId'] = $recruitment['Id'];
        $dataIds['recruitmentDateId'] = $recruitmentDateId;

        // get questions from recruitment form
        $formQuestions = FormModel\FormQuestionQuery::create()
                        ->joinWithQuestion()
                        ->filterByFormId($recruitment['Form.Id'])
                        ->orderByRank(\Criteria::ASC)
                        ->find()->getIterator();
        
        // get defaults
        $defaultQuestions = RecruitmentHelper\Recruitment::$defaultFields;
        
        // set form data
        $this->get('form')->setData($formQuestions, $defaultQuestions);
        
        return $this->render('FrontendBundle:Recruitment:show.html.twig', compact('recruitment', 'formQuestions', 'defaultQuestions', 'dataIds', 'recruitmentDate'));
    }

    /**
     * Register user at event
     * 
     * @param Request $request
     * @return Response 
     */
    public function registerAction(Request $request)
    {
        $data = $dataHidden = $check = $out = $errors = array();
        $validate = null;
        $recruitmentDataEntity = new RecruitmentModel\RecruitmentDate();

        // if form was sended
        if ('POST' === $request->getMethod()) {

            $data = $request->get('data');
            
            $dataHidden = $request->get('hidden-data');
            $recruitmentDataEntity = RecruitmentModel\RecruitmentDateQuery::create()->findOneById($data['recruitmentDateId']);

            $usedLimit = $recruitmentDataEntity->getUsedLimit();
            $setLimit = $recruitmentDataEntity->getSetLimit();
            
            // check if there are enough register places
            if ($usedLimit >= $setLimit) {
                $validate['errors']['_global'] = $this->get('translator')->trans('Niestety zabrakło miejsc na to wydarzenie');
            } else {

                // get temporary data - no extra queries required
                foreach ($dataHidden as $id => $value) {

                    $decode = unserialize(base64_decode($value));

                    $check[$id]['value'] = (isset($data[$id])) ? $data[$id] : '';
                    $check[$id]['type'] = $decode['type'];
                    $check[$id]['validate'] = $decode['validate'];
                    $check[$id]['optional_validate_rule'] = $decode['optional_validate_rule'];
                    $check[$id]['required'] = $decode['required'];

                    unset($decode);
                }

                // check if there are some errors
                $validate = RecruitmentHelper\Recruitment::validate($check, $recruitmentDataEntity->getRecruitmentId(), $this->get('translator'), $this->get('validator'));
                unset($check);
            }
            
            // if no errors occured
            if (empty($validate['errors'])) {

                // save basic user data into database
                $recruitmentUser = new RecruitmentModel\RecruitmentUser();
                // set user to active 
                $data['isActive'] = 1;

                // if is set automatic qualify
                if($recruitmentDataEntity->getIsAutomaticQualify(true)){
                    $data['isQualify'] = 1;
                }
                
                $recruitmentUser->simpleSave($data);
                
                // save extended user data into database
                $recruitmentUserData = new RecruitmentModel\RecruitmentUserData();
                $recruitmentUserData->insertMulti($data, $recruitmentUser->getId());

                // update limit after user has been registered
                if (!$recruitmentDataEntity->isNew()) {

                    $recruitmentDataEntity->setUsedLimit($recruitmentDataEntity->getUsedLimit() + 1);
                    $recruitmentDataEntity->save();
                }
                
                // set recruitment name
                $recruitmentDataEntity->setVirtualColumn('recruitmentName', $data['recruitmentName']);
                
                // send email to registered user
                $this->get('utils_user_mailer')->recruitmentRegister($recruitmentUser, $recruitmentDataEntity);

                $out['state'] = true;
                $out['message'] = $this->get('translator')->trans('Użytkownik został dodany');
                
            } else {

                $out['state'] = false;
                $out['errors'] = $validate['errors'];
                $out['message'] = $this->get('translator')->trans('Wystąpił błąd');
            }
        }

        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Success page after registration
     * 
     * @param Request $request
     * @return Response 
     */
    public function successAction(Request $request)
    {
        $id = $request->get('recruitmentDateId');
        
        // get recruitment
        $recruitmentDate = RecruitmentModel\RecruitmentDateQuery::create()
                ->joinWithRecruitment()
                ->filterById($id)
                ->findOne();
                
        return $this->render('FrontendBundle:Recruitment:success.html.twig', compact('recruitmentDate'));
    }

}
