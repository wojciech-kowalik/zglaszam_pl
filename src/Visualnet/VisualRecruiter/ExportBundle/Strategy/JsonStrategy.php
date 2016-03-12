<?php

namespace Visualnet\VisualRecruiter\ExportBundle\Strategy;

use Visualnet\VisualRecruiter\ExportBundle\Strategy\ExportStrategyInterface;

/**
 * Export to json strategy
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\ExportBundle\Strategy
 * @access public
 * @copyright visualnet.pl
 */
class JsonStrategy implements ExportStrategyInterface
{

    /**
     * Generate method declaration
     * 
     * @param $container
     * @param $data array 
     */    
    public function generate($container, array $export)
    {        
        $response = $container->get("templating")->renderResponse("ExportBundle:Types:export.json.twig", 
                array(
                    "export" => $export
                ));

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Content-Disposition', 'attachment; filename="list.json"');

        return $response;
    }

}
?>
