<?php

namespace Visualnet\VisualRecruiter\ExportBundle\Strategy;

/**
 * Export strategy interface
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\ExportBundle\Strategy
 * @access public
 * @copyright visualnet.pl
 */
interface ExportStrategyInterface {

    /**
     * Generate method declaration
     * 
     * @param $container
     * @param $data array 
     */
    public function generate($container, array $data);
}
?>
