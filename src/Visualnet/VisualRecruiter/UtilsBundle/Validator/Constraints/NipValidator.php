<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Nip validator
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints
 * @access public
 * @copyright visualnet.pl
 */
class NipValidator extends ConstraintValidator
{

    /**
     * Checks if value is nip
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

        //$value = (int) preg_replace("/?:[^\d]/", '', $value);

        if (strlen($value) < 10) {
            
            $this->setMessage($constraint->message, array('{{ value }}' => $value));
            return false;
        }

        $magic =
                $value[0] * 6 +
                $value[1] * 5 +
                $value[2] * 7 +
                $value[3] * 2 +
                $value[4] * 3 +
                $value[5] * 4 +
                $value[6] * 5 +
                $value[7] * 6 +
                $value[8] * 7;

        $ctrl = $magic % 11;

        if ($ctrl == $value[9]) {
            return true;
        }
        
        $this->setMessage($constraint->message, array('{{ value }}' => $value));
        
        return false;
    }

}
