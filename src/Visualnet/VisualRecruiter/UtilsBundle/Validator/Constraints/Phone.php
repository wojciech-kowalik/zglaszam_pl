<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @api
 */
class Phone extends Constraint
{
    public $message = 'This value is not a valid phone value';

    public function validatedBy()
    {
        return "common_validator";
    }       
    
}
