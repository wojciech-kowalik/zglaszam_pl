<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @api
 */
class Postcode extends Constraint
{
    public $message = 'This value is not a valid postcode value';
    
    public function validatedBy()
    {
        return "common_validator";
    }    
    
}
