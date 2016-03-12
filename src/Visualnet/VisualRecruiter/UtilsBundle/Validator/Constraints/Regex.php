<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Visualnet\VisualRecruiter\UtilsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Regex as SymfonyRegex;

/**
 * @Annotation
 *
 * @api
 */
class Regex extends SymfonyRegex
{
    public $error = 'Invalid regular expression was filled in admin module';

}
