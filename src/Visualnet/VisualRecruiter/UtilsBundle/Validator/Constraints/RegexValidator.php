<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\RegexValidator as SymfonyRegexValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Regex validator
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints
 * @access public
 * @copyright visualnet.pl
 */
class RegexValidator extends SymfonyRegexValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @return Boolean Whether or not the value is valid
     *
     * @api
     */    
    public function isValid($value, Constraint $constraint)
    {
        try {

            if (false === $value || '' === $value) {
                return false;
            }            
            
            return parent::isValid($value, $constraint);
            
        } catch (\Exception $e) {

            var_dump($e->getMessage());
            $this->setMessage($constraint->error, array('{{ value }}' => $value));
            return false;
        }
    }

}
