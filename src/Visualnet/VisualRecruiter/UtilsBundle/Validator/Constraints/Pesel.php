<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @api
 */
class Pesel extends Constraint
{
    public $message = 'This value is not a valid Pesel value';
}
