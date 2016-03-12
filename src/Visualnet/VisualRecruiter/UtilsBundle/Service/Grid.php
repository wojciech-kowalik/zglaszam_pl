<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Grid service
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Service
 * @access public
 * @copyright visualnet.pl
 */
class Grid
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Make pager data
     * 
     * @param mixede $object
     * @param array $input
     * @return array 
     */
    public function make($object, array $input, $use = false)
    {
        $required = array("limit", "page", "sidx", "sord", "offset", "filters");
        $keysInput = array_keys($input);
        $diff = array_diff($required, $keysInput);

        if (!empty($diff))
            throw new \InvalidArgumentException("Input array hasn`t all required data");

        if (!is_object($object))
            throw new \InvalidArgumentException("Object required");

        $config = array();
        $method = null;

        // check if is join used
        if ($use) {

            // check if there is i18n table join
            if ($use == "I18n") {

                // make locale
                $langauge = $this->container->get("session")->getLocale();
                $locale = $this->container->get("utils")->getRegionLocale($langauge);
            } else {
                $locale = null;
            }

            // get use join method
            $method = "use" . $use . "Query";

            // get sub object join method
            $subObject = $object->$method($locale);
            $entitySubObjectClass = str_replace("Query", "", get_class($subObject));
        }

        // count collection objects
        $count = $object->count();

        // search elements
        if (!is_null($input["filters"])) {

            foreach ($input["filters"]->rules as $rule) {

                if ($rule->field == "id") {
                    $method = "filterById";

                    if ($use) {
                        $subObject->$method($rule->data);
                    } else {
                        $object->$method($rule->data);
                    }
                } else {

                    $method = "filterBy" . ucfirst($rule->field);

                    if ($use) {
                        $subObject->$method('%' . $rule->data . '%');
                    } else {
                        $object->$method('%' . $rule->data . '%');
                    }
                }
            }
        }
        
        // order elements
        if ($input["sidx"]) {

            // make order method
            $method = "orderBy" . ucfirst($input["sidx"]);

            // check if is join used
            if ($use) {

                if (property_exists($entitySubObjectClass, $input["sidx"])) {
                    $subObject->$method(strtoupper($input["sord"]));
                } else {
                    $object->$method(strtoupper($input["sord"]));
                }
            } else {
                $object->$method(strtoupper($input["sord"]));
            }
        }else{
            $object->orderById(\Criteria::DESC);
        }

        // check if is join used
        if ($use) {
            $subObject->endUse();
        }

        $object->offset($input["offset"]);
        $object->limit($input["limit"]);

        // get objects collection
        $data = $object->find();

        // compute total value
        if ($count > 0) {
            $config["total"] = ceil($count / $input["limit"]);
        } else {
            $config["total"] = 0;
        }

        // make config array
        $config["page"] = $input["page"];
        $config["records"] = $count;
        $config["data"] = $data;
        
        unset($diff, $keysInput, $object);

        return $config;
    }

}
