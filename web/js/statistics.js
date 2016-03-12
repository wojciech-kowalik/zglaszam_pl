
/**
 * Statistic constructor object
 * 
 * @author w.kowalik 
 * @package web\js
 * @access public
 * @copyright visualnet.pl
 */

$(document).ready(function () {
        
    /**
    * Statistic constructor
    * 
    * @author Wojciech Kowalik
    */
    Visualnet.Statistic = function () {
                                                 
        /* get object instance */
        if (typeof Visualnet.Statistic.instance === "undefined") {
            Visualnet.Statistic.instance = this;
        } else {
            return Visualnet.Statistic.instance;
        }             
                    
        
                        
    }; 
    
    // make instance of Statistic
    Visualnet.statistic = new Visualnet.Recruitment();  

});

