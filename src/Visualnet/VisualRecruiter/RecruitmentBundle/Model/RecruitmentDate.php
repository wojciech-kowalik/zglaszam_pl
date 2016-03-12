<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Model;

use Visualnet\VisualRecruiter\RecruitmentBundle\Model\om\BaseRecruitmentDate;


/**
 * Skeleton subclass for representing a row from the 'visual_recruitment_date' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model
 */
class RecruitmentDate extends BaseRecruitmentDate {

    public function isIntegerValue(){
                
        $number = $this->getSetLimit();
        return (is_int($number) and $number != 0);
    }     
    
    public function isRightDate(){
                
        $eventDateFrom = $this->getEventDateFrom();
        $eventDateTo = $this->getEventDateTo();
        
        if(isset($eventDateFrom) 
                && isset($eventDateTo)){
                        
            return ($eventDateFrom->getTimestamp() < $eventDateTo->getTimestamp()) 
                ? true 
                    : false;
            
        }
        
        return true;
        
    }
    
} // RecruitmentDate
