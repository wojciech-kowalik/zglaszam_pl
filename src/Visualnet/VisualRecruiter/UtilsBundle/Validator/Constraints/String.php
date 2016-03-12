<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @api
 */
class String extends Constraint
{
    public $message = 'This value is not a valid string';
    public $pattern = '/^[a-zA-ZąĄćĆęĘłŁńŃóÓśŚźŹżŻÄäÖößÜü]+$/';
    public $match = true;   

    public function validatedBy()
    {
        return "regex_validator";
    }       
    
}
