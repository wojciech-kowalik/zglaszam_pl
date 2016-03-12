<?php

namespace Visualnet\VisualRecruiter\ExportBundle\Strategy;

use Visualnet\VisualRecruiter\ExportBundle\Strategy\ExportStrategyInterface;

/**
 * Export to xml strategy
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\ExportBundle\Strategy
 * @access public
 * @copyright visualnet.pl
 */
class XmlStrategy implements ExportStrategyInterface
{

    /**
     * Generate method declaration
     * 
     * @param $container
     * @param $data array 
     */
    public function generate($container, array $export)
    {

        $response = $container->get("templating")->renderResponse("ExportBundle:Types:export.xml.twig", array(
            "export" => $export)
        );

        $response->headers->set('Content-Type', 'text/xml');
        $response->headers->set('Content-Disposition', 'attachment; filename="list.xml"');

        return $response;
    }

}
?>
