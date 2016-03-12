<?php

namespace Visualnet\MenuBundle\Model;

use Visualnet\MenuBundle\Model\om\BaseMenuI18n;
use Visualnet\VisualRecruiter\UtilsBundle\Helper\String;

/**
 * Skeleton subclass for representing a row from the 'vr_menu_i18n' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.src.Visualnet.MenuBundle.Model
 */
class MenuI18n extends BaseMenuI18n
{

    public function save(\PropelPDO $con = null)
    {
        $this->setSlug(String::slugify($this->getName()));
        return parent::save($con);
    }

}
// MenuI18n
