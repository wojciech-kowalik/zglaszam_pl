<?php

namespace Visualnet\VisualRecruiter\ExportBundle\Strategy;

use Symfony\Component\HttpFoundation\Response;
use Visualnet\VisualRecruiter\UtilsBundle\Helper;
use Visualnet\VisualRecruiter\ExportBundle\Enum\Excel;

/**
 * Export to excel strategy
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\ExportBundle\Strategy
 * @access public
 * @copyright visualnet.pl
 */
class XlsStrategy implements ExportStrategyInterface
{

    /**
     * Generate method declaration
     * 
     * @param $container
     * @param $data array 
     */
    public function generate($container, array $export)
    {
        // assertion export
        if (empty($export)) {
            throw new \InvalidArgumentException("Data required");
        }

        $exportParameter = $container->getParameter("export");

        // assertion parameters
        if (!isset($exportParameter)) {
            throw new \InvalidArgumentException("Export parameters required");
        }

        $excelService = new \stdClass();
        $extension = false;

        // get proper xls service
        switch ($exportParameter["excel_type"]) {

            case Excel::XLS5: {

                    $excelService = $container->get("xls.service_xls5");
                    $extension = "xls";
                }break;

            case Excel::XLS2007: {

                    $excelService = $container->get("xls.service_xls2007");
                    $extension = "xlsx";
                }break;

            default: throw new \InvalidArgumentException("Excel export type not supported");
                break;
        }

        // styles
        $styleArray = array("font" => array("bold" => true));

        // author data
        $excelService->excelObj->getProperties()->setCreator("zglaszam.pl")
                ->setLastModifiedBy("zglaszam.pl");

        // add id header on top an array
        array_unshift($export["headers"], "id");

        $index = 1;
        $i = 0;
        $xlsHeaders = Helper\String::generateXlsHeader(sizeof($export["headers"]));

        // iterate over headers data
        foreach ($export["headers"] as $id => $header) {
            $excelService->excelObj->setActiveSheetIndex(0)->setCellValue($xlsHeaders[$id] . $index, ucfirst($header));
            $excelService->excelObj->getActiveSheet()->getColumnDimensionByColumn($id)->setWidth(20);
            $excelService->excelObj->getActiveSheet()->getStyle($xlsHeaders[$id] . $index)->applyFromArray($styleArray);
        }

        // iterate over user data
        foreach ($export["data"] as $id => $data) {

            $index++;
            $i = 0;

            // set id data
            $excelService->excelObj->setActiveSheetIndex(0)->setCellValue($xlsHeaders[$i] . $index, $id);

            // set next user data
            foreach ($data as $item) {

                $i++;
                $excelService->excelObj->setActiveSheetIndex(0)->setCellValue($xlsHeaders[$i] . $index, $item);
            }
        }

        // name of sheet
        $excelService->excelObj->getActiveSheet()->setTitle("List");

        // set sheet to active
        $excelService->excelObj->setActiveSheetIndex(0);

        //create the response
        $response = $excelService->getResponse();
        $response->headers->set("Content-Type", "text/vnd.ms-excel; charset=utf-8");
        $response->headers->set("Content-Disposition", "attachment;filename=list." . $extension);
        $response->headers->set("Pragma", "public");
        $response->headers->set("Cache-Control", "maxage=1");

        return $response;
    }

}
?>
