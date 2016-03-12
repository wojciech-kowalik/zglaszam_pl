<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Model;

use Visualnet\VisualRecruiter\RecruitmentBundle\Model\om\BaseRecruitmentUserData;

/**
 * Skeleton subclass for representing a row from the "visual_recruitment_user_data" table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model
 */
class RecruitmentUserData extends BaseRecruitmentUserData
{

    /**
     * Insert many user data
     * 
     * @param array $data
     * @param int $userId
     * @return boolean
     */
    public function insertMulti(array $data, $userId)
    {
        $connection = \Propel::getConnection();
        $arguments = array();
        
        $sql = "INSERT INTO " . RecruitmentUserDataPeer::TABLE_NAME . " ";
        $sql .= "(" . RecruitmentUserDataPeer::USER_RECRUITMENT_ID . ", " . RecruitmentUserDataPeer::QUESTION_ID . ", " . RecruitmentUserDataPeer::VALUE . ") VALUES ";

        foreach ($data as $id => $value) {
            
            if(!is_numeric($id)){
                continue;
            }
            
            // for checkbox questions
            if(is_array($value)){
                $value = implode(', ', $value);
            }            
            
            $arguments[] = "(" . $userId . ", " . $id . ", \"" . $value . "\")";
        }

        $sql .= implode(", ", $arguments);
        $statement = $connection->prepare($sql);

        return $statement->execute();
    }

}
// RecruitmentUserData
