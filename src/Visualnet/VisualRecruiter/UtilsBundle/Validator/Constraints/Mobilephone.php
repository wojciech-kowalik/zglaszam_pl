<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @api
 */
class MobilePhone extends Constraint
{
    public $message = 'This value is not a valid mobile phone value';

    public function validatedBy()
    {
        return "common_validator";
    }       
    
}
