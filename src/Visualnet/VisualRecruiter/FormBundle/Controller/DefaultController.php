<?php

namespace Visualnet\VisualRecruiter\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Visualnet\VisualRecruiter\FormBundle\Model;
use Visualnet\VisualRecruiter\FormBundle\Form;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Visualnet\VisualRecruiter\UtilsBundle\Helper;
use Visualnet\VisualRecruiter\RecruitmentBundle\Helper as RecruitmentHelper;

/**
 * Default form controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\FormBundle\Controller
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
            return $this->render('FormBundle:Default:index.' . $format . '.twig');
        }           

        $limit = $this->container->getParameter('paginator_elements_per_site');
        $page = $request->get('page');

        $input = array(
            'limit' => $limit,
            'page' => $request->get('page'),
            'sidx' => $request->get('sidx'),
            'sord' => $request->get('sord'),
            'offset' => $limit * $page - $limit,
            'filters' => json_decode($request->get('filters'))
        );

        $forms = Model\FormQuery::create()->joinWithUser();
        
        $context = $this->get('security.context');
        $roleExists = $context->isGranted('ROLE_ADMIN');

        if (!$roleExists) {

            $forms->join('User', \Criteria::LEFT_JOIN)
                    ->useUserQuery()
                        ->filterById($context->getToken()->getUser()->getId())
                    ->endUse();
        }         

        return $this->render('FormBundle:Default:index.' . $request->getRequestFormat() . '.twig', array('config' => $this->get('utils_grid')->make($forms, $input)
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

        $_form = new Model\Form();
        $form = $this->createForm(new Form\Form(), $_form);

        return $this->render('FormBundle:Default:form.html.twig', array(
                    'form' => $form->createView(),
                    'object' => $_form
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
        $_form = new Model\Form();
        $form = $this->createForm(new Form\Form(), $_form);

        return $this->process($request, $form, $_form);
    }

    /**
     * Show populated form
     * 
     * @param Form $form
     * @param Request $request
     * @return mixed
     */
    public function editAction(Request $request)
    {
        $object = Model\FormQuery::create()->findOneById($request->get('id'));
        $form = $this->createForm(new Form\Form(), $object)->createView();

        return $this->render('FormBundle:Default:form.html.twig', compact('form', 'object'));
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

        if ($request->get('sf_method') != 'PUT') {
            throw $this->createNotFoundException('Zła metoda przesyłania formularza');
        }

        $_form = Model\FormQuery::create()->findOneById($request->get('id'));
        $form = $this->createForm(new Form\Form(), $_form);

        return $this->process($request, $form, $_form);
    }

    /**
     * Delete data
     *   
     * @Secure(roles='ROLE_ADMIN_GODMODE, ROLE_USER_ADMINGROUP')
     * @param Request $request
     * @return RedirectResponse
     * @throws NotFoundHttpException 
     */
    public function deleteAction(Request $request)
    {
        $out = array();
        $form = Model\FormQuery::create()->findOneById($request->get('id'));

        if (!$form) {
            $out['state'] = false;
            $out['message'] = sprintf('Nie ma takiego formularza id: %s', $request->get('id'));
        } else {

            $form->delete();

            $out['state'] = true;
            $out['message'] = 'Usunięto formularz';
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
    private function process(Request $request, $form, $object)
    {
        $out = array();

        if ('POST' === $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {

                $context = $this->container->get('security.context');

                // check security context for admin data
                if ($context->isGranted('ROLE_ADMIN')) {

                    $object->setGroupId(1); // default group for admin
                } else {
                    $object->setGroupId($context->getToken()->getUser()->getGroup()->getId());
                }

                $object->setUserId($context->getToken()->getUser()->getId());

                $object->save();

                $out['state'] = true;

                if ('PUT' == $request->get('sf_method')) {
                    $out['message'] = 'Wyedytowano formularz';
                } else {
                    $out['message'] = 'Dodano formularz';
                }
            } else {

                $out['state'] = false;
                $out['message'] = 'Wystąpił błąd w formularzu';
                $out['errors'] = json_encode(Helper\String::getErrorMessages($form));
            }
        }

        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    
    /**
     * Get forms
     * 
     * @param Request $request
     * @return Response 
     */
    public function getAction(Request $request)
    {
        $forms = $this->container->get('user')->getForms()->find();
        $formID = $request->get('formID');
     
        return $this->render('FormBundle:Default:get.html.twig', compact('forms', 'formID'));
    }    
    
    
    /**
     * Get form preview
     * 
     * @param Request $request
     * @return Response 
     */
    public function previewAction(Request $request)
    {
        $recruitmentId = $request->get('id');
        
        // get questions from register form
        $formQuestions = Model\FormQuestionQuery::create()
                        ->joinWithQuestion()
                        ->filterByFormId($recruitmentId)
                        ->orderByRank(\Criteria::ASC)
                        ->find()->getIterator();   
        
        // get defaults
        $defaultQuestions = RecruitmentHelper\Recruitment::$defaultFields;
        
        // set form data
        $this->get('form')->setData($formQuestions, $defaultQuestions);
        
        return $this->render('FormBundle:Default:preview.html.twig', compact('formQuestions', 'defaultQuestions'));

    }      

}
