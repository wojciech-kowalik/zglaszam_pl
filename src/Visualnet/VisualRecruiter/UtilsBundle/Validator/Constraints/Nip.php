<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @api
 */
class Nip extends Constraint
{
    public $message = 'This value is not a valid NIP value';
    public $expression = array();
}
