<?php

namespace Visualnet\VisualRecruiter\ExportBundle\Strategy;

use Visualnet\VisualRecruiter\ExportBundle\Strategy\ExportStrategyInterface;

/**
 * Export to csv strategy
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\ExportBundle\Strategy
 * @access public
 * @copyright visualnet.pl
 */
class CsvStrategy implements ExportStrategyInterface
{

    /**
     * Generate method declaration
     * 
     * @param $container
     * @param $data array 
     */
    public function generate($container, array $export)
    {

        $exportParameter = $container->getParameter("export");

        $response = $container->get("templating")->renderResponse("ExportBundle:Types:export.csv.twig", array(
            "export" => $export,
            "separator" => $exportParameter["csv_separator"])
        );

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="list.csv"');

        return $response;
    }

}
?>
