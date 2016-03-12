<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Pesel validator
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints
 * @access public
 * @copyright visualnet.pl
 */
class PeselValidator extends ConstraintValidator
{

    /**
     * Checks if value is pesel
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @return Boolean Whether or not the value is valid
     *
     */
    public function isValid($value, Constraint $constraint)
    {
        
        if (null === $value || '' === $value) {
            return true;
        }

        // remove - from string
        $value = str_replace('-', '', $value);
        
        if (!is_scalar($value) && !(is_object($value) && method_exists($value, "__toString"))) {
            throw new UnexpectedTypeException($value, "int");
        }

        $value = (int) $value;

        if (!preg_match('/^[0-9]{11}$/', $value)) { // check if value has 11 signs
            
            $this->setMessage($constraint->message, array('{{ value }}' => $value));
            return  false;
        }

        $arrSteps = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3); // array with corresponding weight
        $intSum = 0;

        for ($i = 0; $i < 10; $i++) {
            $intSum += $arrSteps[$i] * $value[$i];
        }

        $int = 10 - $intSum % 10; // compute sum control
        $intControlNr = ($int == 10) ? 0 : $int;

        if ($intControlNr == $value[10]) {
            return true;
        }
        

        $this->setMessage($constraint->message, array('{{ value }}' => $value));
        return false;
    }

}
