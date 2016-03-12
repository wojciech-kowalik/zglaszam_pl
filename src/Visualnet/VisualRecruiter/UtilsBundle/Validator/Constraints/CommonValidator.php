<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Visualnet\VisualRecruiter\UtilsBundle\Helper\String;

/**
 * Common validator with expression support
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints
 * @access public
 * @copyright visualnet.pl
 */
class CommonValidator extends ConstraintValidator
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Checks if value equals with expression
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @return Boolean Whether or not the value is valid
     *
     */
    public function isValid($value, Constraint $constraint)
    {

        $valid = false;
        $param = null;
        
        if (false === $value || '' === $value) {
            return false;
        }

        // get class Constraint name
        $expressionClass = String::getClassName($constraint, true);
                
        // check if param exists
        try {
            $param = $this->container->getParameter("validator");
        } catch (\InvalidArgumentException $e) {}

        // check format
        $format = trim(preg_replace("/\d/", "9", $value));     
                
        $valid = ($param[$expressionClass."_expression"] === $format) 
                ? true 
                    : false;        
        
        if (!$valid) {
            $this->setMessage($constraint->message, array('{{ value }}' => $value));
        }
       
        return false;
    }

}
