<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Helper;

use Visualnet\VisualRecruiter\UtilsBundle\Helper;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model;
use Visualnet\VisualRecruiter\QuestionBundle\Model as QuestionModel;

/**
 * Recruitment helper
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\RecruitmentBundle\Helper
 * @access public
 * @copyright visualnet.pl
 */
class Recruitment
{
    /**
     * Default values for form
     * @var array
     */
    public static $defaultFields = array(
        
        "name" => array(
            "translate" => "Imię",
            "type" => "text",
            "validate" => null,
            "required" => true,
            "extras" => "autofocus",
            "value" => "",
            "export" => true
        ),
        "surname" => array(
            "translate" => "Nazwisko",
            "type" => "text",
            "validate" => null,
            "required" => true,
            "extras" => null,
            "value" => "",
            "export" => true
        ),
        "email" => array(
            "translate" => "Email",
            "type" => "text",
            "validate" => "email",
            "required" => true,
            "extras" => null,
            "value" => "",
            "export" => true
        ),
        "email_repeat" => array(
            "translate" => "Powtórz email",
            "type" => "text",
            "validate" => "email",
            "required" => true,
            "extras" => null,
            "value" => "",
            "export" => false
        )        
    );    
    
    /**
     * Validate user data method
     * 
     * @param array $data
     * @param Service $translator
     * @param Service $validator
     * @return array
     */
    public static function validate(array $data, $recruitmentId, $translator, $validator)
    {
        $errors = array();

        foreach ($data as $fieldID => $fieldValue) {

            // mark required fields
            if ($fieldValue["required"]
                    && empty($fieldValue["value"])) {

                $errors[$fieldID][] = $translator->trans("Pole wymagane");
            }

            // check if validation class exists
            if (class_exists($fieldValue["validate"])) {

                $object = null;

                if (empty($fieldValue["value"])) {
                    $fieldValue["value"] = false;
                }

                $validateType = Helper\String::getClassName($fieldValue["validate"], true);

                // if regex get pattern
                if ($validateType == "regex") {
                    $object = new $fieldValue["validate"](array("pattern" => '/' . $fieldValue["optional_validate_rule"] . '/'));
                } else {
                    $object = new $fieldValue["validate"];
                }
                
                // if question is chekbox type and has a lot of answers
                if ($fieldValue["type"] === QuestionModel\QuestionPeer::TYPE_CHECKBOX) {
                    
                    if(is_array($fieldValue["value"])) { // if there are many answers 
                        $fieldValue["value"] = implode(", ", $fieldValue["value"]);
                    }
                   
                }
                
                // validate by constraint class
                $errorMessage = $validator->validateValue($fieldValue["value"], $object);

                // if error occured get it into errors table
                if (isset($errorMessage[0])) {

                    $msg = $errorMessage[0]->getMessage();

                    if (!empty($msg)) {
                        $errors[$fieldID][] = $translator->trans($msg);
                    }
                }

                unset($object);
            }
        }

        // check if email exists in recruitment scope
        if (!isset($errors["email"]) || !isset($errors["email_repeat"])) {

            $email = Model\RecruitmentUserQuery::create()
                    ->select("Email")
                    ->filterByRecruitmentId($recruitmentId)
                    ->findOneByEmail($data["email"]["value"]);

            // make error when email already exists
            if ($data["email"]["value"] === $email) {
                $errors["email"][] = $translator->trans("Taki email już istnieje");
            }
            
            // check if email is the same
            if ($data["email"]["value"] !== $data["email_repeat"]["value"]) {
                $errors["email_repeat"][] = $translator->trans("Adresy email nie są takie same");
            }

        }

        return array("errors" => $errors);
    }

}
