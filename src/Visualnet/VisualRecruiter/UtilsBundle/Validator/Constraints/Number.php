<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @api
 */
class Number extends Constraint
{
    public $message = 'This value is not a valid number';
    public $pattern = '/(?<=^| )\d+(\.\d+)?(?=$| )/';
    public $match = true;   

    public function validatedBy()
    {
        return "regex_validator";
    }       
    
}
