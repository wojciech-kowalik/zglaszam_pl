<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Model;

use Visualnet\VisualRecruiter\RecruitmentBundle\Model\om\BaseRecruitmentUser;

/**
 * Skeleton subclass for representing a row from the 'visual_recruitment_user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model
 */
class RecruitmentUser extends BaseRecruitmentUser
{

    /**
     * Simple save user recruitment data by name of the fields
     * @param array $data 
     */
    public function simpleSave(array $data)
    {

        foreach ($data as $field => $value) {

            $method = "set" . ucfirst($field);

            if (is_numeric($field) || !method_exists($this, $method)) {
                continue;
            }
            
            $this->$method($value);
        }

        return parent::save();
    }

}
// RecruitmentUser
