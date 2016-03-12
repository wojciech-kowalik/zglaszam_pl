<?php

namespace Visualnet\VisualRecruiter\ExportBundle\Controller;

use Visualnet\VisualRecruiter\ExportBundle\Strategy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Visualnet\VisualRecruiter\ExportBundle\Enum\Types;

/**
 * Default export controller
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\AdminBundle\Controller
 * @access public
 * @copyright visualnet.pl
 */
class DefaultController extends Controller
{
    /**
     * Make export
     * 
     * @param $request Request
     * @return Response
     */
    public function makeAction(Request $request)
    {
        
        // get request data
        $export = $request->get("export");
        $type = $request->get("type");

        $exportStrategy = new \stdClass();
  
        // make STRATEGY design pattern
        switch ($type) {

            case Types::CSV:
                $exportStrategy = new Strategy\CsvStrategy();
                break;
            case Types::XML:
                $exportStrategy = new Strategy\XmlStrategy();
                break;
            case Types::XLS:
                $exportStrategy = new Strategy\XlsStrategy();
                break;
            case Types::JSON:
                $exportStrategy = new Strategy\JsonStrategy();
                break;            

            default: throw new \Exception("Export not supported");
                break;
        }

        // genearte export data
        return $exportStrategy->generate($this->container, $export);
    }

}