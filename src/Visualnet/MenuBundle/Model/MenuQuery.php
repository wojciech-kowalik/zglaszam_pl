<?php

namespace Visualnet\MenuBundle\Model;

use Visualnet\MenuBundle\Model\om\BaseMenuQuery;


/**
 * Skeleton subclass for performing query and update operations on the 'vr_menu' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.src.Visualnet.MenuBundle.Model
 */
class MenuQuery extends BaseMenuQuery {


    public function getItems($locale = "pl_PL", $showActive = false){

        $this->joinWithI18n($locale);
        
        if($showActive)
            $this->filterByIsActive(true);

        return $this->orderByRank();

    }        
    
} // MenuQuery
