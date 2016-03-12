<?php

namespace Visualnet\VisualRecruiter\UserBundle\Controller;

use Visualnet\UserBundle\Model;
use Visualnet\VisualRecruiter\UserBundle\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Visualnet\UserBundle\Controller\DefaultController as VisualnetUserBundleDefaultController;
use Visualnet\UserBundle\Lib;
use JMS\SecurityExtraBundle\Annotation\Secure;
use \PropelObjectCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Visualnet\VisualRecruiter\UtilsBundle\Helper;

/**
 * Default user controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class DefaultController extends VisualnetUserBundleDefaultController
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
            return $this->render("UserBundle:User:index." . $format . ".twig");
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

        $users = Model\UserQuery::create();

        // if user isn`t system admin get admin`s group`s users
        if (!$roleExists) {
            $users->getAdminGroupUsers($context->getToken()->getUser());
        }

        return $this->render("UserBundle:User:index." . $format . ".twig", array("config" => $this->get("utils_grid")->make($users, $input)
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
        $user = new Model\User();

        $form = $this->createForm(new Form\User(), $user);

        return $this->render("UserBundle:User:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $user
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
        $user = new Model\User();
        $form = $this->createForm(new Form\User(), $user);

        return $this->process($request, $form, $user);
    }

    /**
     * Show populated form
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN, ROLE_USER_ADMINGROUP")
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function editAction(Model\User $user, Request $request)
    {
        $form = $this->createForm(new Form\User(), $user);

        return $this->render("UserBundle:User:form.html.twig", array(
                    "form" => $form->createView(),
                    "object" => $user
                ));
    }

    /**
     * Edit data
     * 
     * @Secure(roles="ROLE_ADMIN_GODMODE, ROLE_ADMIN, ROLE_USER_ADMINGROUP")
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function updateAction(Model\User $user, Request $request)
    {

        if ($request->get("sf_method") != "PUT") {
            throw $this->createNotFoundException("Zła metoda przesyłania formularza");
        }

        $form = $this->createForm(new Form\User(), $user);

        return $this->process($request, $form);
    }

    /**
     * Change password
     *   
     * @param Request $request
     * @return Response
     */
    public function changePasswordAction(Request $request)
    {

        $out = array();
        $errorMessage = false;

        if ("POST" === $request->getMethod()) {

            $password = $request->get("password");
            $passwordRepeat = $request->get("password-repeat");
            $id = $request->get("id");

            // check if data aren`t empty 
            if (empty($password)
                    && empty($passwordRepeat)) {

                $errorMessage = $this->get("translator")->trans("Hasło jest puste");
            }

            // check if passwords are the same
            if ($password !== $passwordRepeat) {
                $errorMessage = $this->get("translator")->trans("Hasła nie są jednakowe");
            }
            
            $passwordLength = $this->container->getParameter("password_length");
            
            // check if password has required length
            if (strlen($password) < $passwordLength) {
                $errorMessage = $this->get("translator")->trans("Wymagana długość hasła to ".$passwordLength." znaków");
            }

            // if error exists
            if ($errorMessage) {

                $out["state"] = false;
                $out["message"] = $this->get("translator")->trans("Wystąpił błąd w formularzu");
                $out["errors"] = array('1' => $errorMessage);
                
            } else {

                // get user and change his password
                $user = Model\UserQuery::create()
                        ->findOneById($id);

                $factory = $this->get("security.encoder_factory");
                $userProxy = new Lib\UserProxy(new \Visualnet\UserBundle\Model\User());
                $encoder = $factory->getEncoder($userProxy);

                $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
                $user->save();

                $out["state"] = true;
                $out["message"] = $this->get("translator")->trans("Hasło zostało zmienione");
            }

            $response = new Response(json_encode($out));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
            
        } else {

            // if data wasn`t sended show default layout
            return $this->render("UserBundle:Password:change.html.twig");
        }
    }
    
    /**
     * Remind password
     *   
     * @param Request $request
     * @return Response
     */
    public function remindPasswordAction(Request $request)
    {
        $out = array();

        if ("POST" === $request->getMethod()) {

            $user = Model\UserQuery::create()
                    ->findOneByEmail($request->get("email"));

            if ($user) {

                // generate password
                $password = $passwordPlain = strtolower($user->getUsername()) . substr(uniqid(), -4);

                $factory = $this->get("security.encoder_factory");
                $userProxy = new Lib\UserProxy(new \Visualnet\UserBundle\Model\User());
                $encoder = $factory->getEncoder($userProxy);
                $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

                $user->save();

                // send mail to user
                $user->setPassword($passwordPlain); // send plain password to user entity
                $this->get("utils_user_mailer")->remindPassword($user);

                $out["state"] = true;
                $out["message"] = $this->get("translator")->trans("Nowe hasło zostało wysłane na podany email");
                
            } else {

                $out["state"] = false;
                $out["message"] = $this->get("translator")->trans("Taki email nie istnieje");
            }

            $response = new Response(json_encode($out));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
            
        } else {

            // if data wasn`t sended show default layout
            return $this->render("UserBundle:Password:remind.html.twig");
        }
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
        $user = Model\UserQuery::create()->findPk($request->get("id"));

        if (!$user) {
            $out["state"] = false;
            $out["message"] = sprintf("Nie ma takiego użytkownika id: %s", $request->get("id"));
        } else {

            $user->delete();

            $out["state"] = true;
            $out["message"] = "Usunięto użytkownika";
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

        if ("POST" === $request->getMethod()) {

            $userRolesData = $request->get("userroles");
            $userGroupsData = $request->get("usergroups");

            $form->bindRequest($request);

            $userRole = new Model\UserRole();
            $userGroup = new Model\UserGroup();

            $user = $form->getData();

            if ($form->isValid()) {

                $user->save();
                //$user->getGroup()->save();

                $out["state"] = true;

                // manipulate roles
                Model\UserRoleQuery::create()->filterByUserId($user->getId())->delete();

                if (!empty($userRolesData)) {
                    $userRole->insertMulti($userRolesData, $user->getId());
                }

                // manipulate groups
                Model\UserGroupQuery::create()->filterByUserId($user->getId())->delete();

                if (!empty($userGroupsData)) {
                    $userGroup->insertMulti($userGroupsData, $user->getId());
                }

                // when user is edited
                if ("PUT" == $request->get("sf_method")) {
                    $out["message"] = "Wyedytowano użytkownika";
                } else { // when new user has been added
                    // generate password
                    $password = $passwordPlain = strtolower($user->getUsername()) . substr(uniqid(), -4);

                    $factory = $this->get("security.encoder_factory");
                    $userProxy = new Lib\UserProxy(new \Visualnet\UserBundle\Model\User());
                    $encoder = $factory->getEncoder($userProxy);

                    $user->setType(Model\UserPeer::TYPE_INDIVIDUAL);
                    $user->setIsActive(true);
                    $user->setIsAgreeProcessing(true);
                    $user->setIsAgreeRegulations(true);
                    $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

                    $user->save();

                    $out["state"] = true;

                    // send mail to user
                    $user->setPassword($passwordPlain); // send plain password to user entity
                    $this->get("utils_user_mailer")->create($user);

                    // set flash
                    $out["message"] = "Dodano użytkownika";
                }
            } else {

                if ("PUT" != $request->get("sf_method")) {

                    // if error exists set default roles data
                    if (!empty($userRolesData)) {

                        $collection = new \PropelCollection();
                        $userRole->setUserId(0); // default value when new user is added
                        foreach ($userRolesData as $userRoleData) {

                            $clone = clone $userRole;
                            $clone->setRoleId($userRoleData["role_id"]);
                            $collection->append($clone);
                        }

                        // assign roles to new user
                        $user->setUserRoles($collection);
                    }

                    // if error exists set default groups data
                    if (!empty($userGroupsData)) {

                        $collection = new \PropelCollection();
                        $userGroup->setUserId(0); // default value when new user is added
                        foreach ($userGroupsData as $userGroupData) {

                            $clone = clone $userGroup;
                            $clone->setGroupId($userGroupData["group_id"]);
                            $collection->append($clone);
                        }

                        // assign groups to new user
                        $user->setUserGroups($collection);
                    }
                }

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
     * Activate user action
     * 
     * @param string $token
     * @return void
     * @throws \Exception 
     */
    public function activateAction($token)
    {
        $currentUser = null;
        $iterator = Model\UserQuery::create()->find()->getIterator();

        // iterate on users collections
        while ($iterator->valid()) {

            // check if user entity exists
            if ($this->get("utils")->checkUserToken($iterator->current(), $token)) {
                $currentUser = $iterator->current();
                break;
            }

            $iterator->next();
        }

        try {

            if ($currentUser) {

                if ($currentUser->getIsActive() == true) {
                    throw new \Exception("Ten użytkownik został już aktywowany");
                }

                // activate user data
                $currentUser->setIsActive(true);
                $currentUser->save();

                $this->get("session")->setFlash("success", "Użytkownik został aktywowany - Twoje konto zostało aktywowane. Dziękujemy za rejestrację, możesz się teraz zalogować i zorganizować swoją pierwszą rekrutację");
            } else {
                throw new \Exception("Nie ma użytkownika z takimi danymi");
            }
        } catch (\Exception $e) {
            $this->get("session")->setFlash("error", $e->getMessage());
        }

        return $this->render("UserBundle:Register:activate.html.twig");
    }

    /**
     * Register user action
     * 
     * @param Request $request
     * @return template 
     */
    public function registerAction(Request $request)
    {
        $defaultRoles = $this->container->getParameter("user_register_role");
        $collection = new \PropelCollection();
        $user = new Model\User();
        $errors = $matches = array();

        $group = new Model\Group();
        $user->addGroup($group);

        $form = $this->createForm(new Form\UserRegister(), $user);

        if ("POST" === $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {

                $factory = $this->get("security.encoder_factory");
                $userProxy = new Lib\UserProxy($user);
                $encoder = $factory->getEncoder($userProxy);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());

                $user->setPassword($password);

                $group = $user->getGroup();

                // if user is individual set username as name of a group
                if ($user->getType() == Model\UserPeer::TYPE_INDIVIDUAL) {
                    $group->setName($user->getUsername());
                }

                // iterate on default config roles
                foreach ($defaultRoles as $defaultRole) {

                    $role = Model\RoleQuery::create()->filterByName($defaultRole)->findOne();

                    $userRole = new Model\UserRole();
                    $userRole->setUserId($user->getId());
                    $userRole->setRoleId($role->getId());

                    $collection->append($userRole);
                }

                // set roles for user
                $user->setUserRoles($collection);

                $group->setSlug(Helper\String::slugify($group->getName()));

                // set admin group
                $user->getUserGroups()->getFirst()->setIsGroupAdmin(true);

                // save user data
                $user->save();

                // make user hash for activate
                $user->token = $this->get("utils")->setUserToken($user);

                // send register email
                $this->get("utils_user_mailer")->register($user);

                $this->get("session")->setFlash("success", "Dziękujemy za przesłane dane, na podany adres email została wysłana wiadomość z linkiem aktywacyjnym");

                return $this->redirect($this->generateUrl("FrontendBundle_homepage_locale"));
                
            } else {

                // translate form errors

                $formErrors = Helper\String::getErrorMessages($form);
                $translator = $this->get("translator");
                //$search = array("Username", "Email");

                foreach ($formErrors as $key => $error) {

                    if (is_array($error)) {

                        foreach ($error as $item) {
                            array_push($errors, $translator->trans($item));
                        }
                    } else {
                        preg_match('/\"(.*)\"/', $error, $matches);
                        array_push($errors, $translator->trans("Taka wartość \"" . $matches[1] . "\" istnieje już w bazie"));
                    }
                }
                
                $count = count($errors);
                
                if($count == 1){
                    $message = "jest błąd";
                }else{
                    $message = "wystąpiły błędy";
                }
                
                $this->get("session")->setFlash("error", "W formularzu rejestracyjnym ".$message.", prosimy sprawdź poprawność wprowadzonych danych");
            }
        }

        return $this->render("UserBundle:Register:register.html.twig", array(
                    "form"      => $form->createView(),
                    "errors"    => $errors
                ));
    }

    /**
     * Generate user login
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \InvalidArgumentException 
     */
    public function generateLoginAction(Request $request)
    {

        // if no ajax request throw exception
        if (!$request->isXmlHttpRequest()) {
            throw new \InvalidArgumentException("Not supported method");
        }

        $out = array();
        $name = $request->get("name");
        $surname = $request->get("surname");

        $nameComponent = substr(strtolower($name), 0, 1);
        $surnameComponent = strtolower(Helper\String::clean($surname));
        $login = $nameComponent . '.' . $surnameComponent;

        // check if user exists
        $user = Model\UserQuery::create()->findByUsername($login);

        $out["state"] = false;

        if ($user->isEmpty()) {
            $out["state"] = true;
            $out["login"] = $login;
        } else {
            $out["state"] = true;
            $out["login"] = $login . substr(rand(0, 1000), 0, 2);
        }

        $response = new Response(json_encode($out));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
