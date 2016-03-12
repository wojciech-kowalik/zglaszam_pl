<?php

namespace Visualnet\VisualRecruiter\QuestionBundle\Helper;

use Visualnet\VisualRecruiter\UtilsBundle\UtilsBundle\Helper\String;

/**
 * Helper for question
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\QuestionBundle
 * @access public
 * @copyright visualnet.pl
 */
class Question
{

    const EMAIL_VALIDATION_CLASS = "Symfony\Component\Validator\Constraints\Email";
    const NIP_VALIDATION_CLASS = "Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints\Nip";
    const URL_VALIDATION_CLASS = "Symfony\Component\Validator\Constraints\Url";
    const PHONE_VALIDATION_CLASS = "Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints\Phone";
    const MOBILEPHONE_VALIDATION_CLASS = "Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints\MobilePhone";
    const POSTCODE_VALIDATION_CLASS = "Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints\Postcode";
    const STRING_VALIDATION_CLASS = "Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints\String";
    const NUMBER_VALIDATION_CLASS = "Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints\Number";
    const REGEX_VALIDATION_CLASS = "Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints\Regex";

    /**
     * Array with sets
     * 
     * @var array 
     */
    private static $sets = array(
        "email"         => Question::EMAIL_VALIDATION_CLASS,
        "nip"           => Question::NIP_VALIDATION_CLASS,
        "url"           => Question::URL_VALIDATION_CLASS,
        "phone"         => Question::PHONE_VALIDATION_CLASS,
        "mobilephone"   => Question::MOBILEPHONE_VALIDATION_CLASS,
        "postcode"      => Question::POSTCODE_VALIDATION_CLASS,
        "string"        => Question::STRING_VALIDATION_CLASS,
        "number"        => Question::NUMBER_VALIDATION_CLASS,
        //"regex"         => Question::REGEX_VALIDATION_CLASS
    );

    /**
     * Gets the list of values for immutable values
     * 
     * @return array
     */
    public static function getPredefinedValidators()
    {
        return static::$sets;
    }

    /**
     * Get value from validator
     * 
     * @return array
     */
    public static function getPredefinedValidator($name)
    {

        if (!is_scalar($name) && !(is_object($name) && method_exists($name, '__toString'))) {
            throw new \UnexpectedTypeException($name, "string");
        }

        if (!in_array($name, static::$sets)) {
            throw new \InvalidArgumentException("Wrong parameter");
        }

        return Question::$sets;
    }
    
    /**
     * Get translate of validators names
     * 
     * @return array
     */
    public static function getRules($translator){
        
        $predefinedValidators = array_flip(self::getPredefinedValidators());
        
        // translate custom validators names
        if (!empty($predefinedValidators)) {

            foreach ($predefinedValidators as &$validator) {
                $validator = $translator->trans($validator);
            }
        }       
        
        return $predefinedValidators;
        
    }

}
?>
