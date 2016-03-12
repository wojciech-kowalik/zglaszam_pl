<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Helper;

use Symfony\Component\Form\Form;

/**
 * String helper
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Helper
 * @access public
 * @copyright visualnet.pl
 */
class String
{

    /**
     * Make slug from string
     * 
     * @param type $text
     * @return string 
     */
    public static function slugify($text)
    {
        if(!is_string($text)){
            throw new \InvalidArgumentException("Wrong input parameter");
        }
        
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
    
    /**
     * Generate xls/x letter headers
     * 
     * @param $count int
     * @param $suffix mixed
     * @return array
     */    
    public static function generateXlsHeader($count){
     
        if(!is_int($count)){
            throw new \InvalidArgumentException("Counter of elements required");
        }
        
        $start = 'A';
        $headers = array();
        
        for($i = 0; $i <= $count; $i++){
            array_push($headers, $start++);
        }
        
        return $headers;
        
    }

    /**
     * Clean data in string
     * 
     * @param string $value
     * @return string
     */
    public static function clean($value)
    {
        $data = array(
            //WIN
            "\xb9" => "a", "\xa5" => "A", "\xe6" => "c", "\xc6" => "C",
            "\xea" => "e", "\xca" => "E", "\xb3" => "l", "\xa3" => "L",
            "\xf3" => "o", "\xd3" => "O", "\x9c" => "s", "\x8c" => "S",
            "\x9f" => "z", "\xaf" => "Z", "\xbf" => "z", "\xac" => "Z",
            "\xf1" => "n", "\xd1" => "N",
            //UTF
            "\xc4\x85" => "a", "\xc4\x84" => "A", "\xc4\x87" => "c", "\xc4\x86" => "C",
            "\xc4\x99" => "e", "\xc4\x98" => "E", "\xc5\x82" => "l", "\xc5\x81" => "L",
            "\xc3\xb3" => "o", "\xc3\x93" => "O", "\xc5\x9b" => "s", "\xc5\x9a" => "S",
            "\xc5\xbc" => "z", "\xc5\xbb" => "Z", "\xc5\xba" => "z", "\xc5\xb9" => "Z",
            "\xc5\x84" => "n", "\xc5\x83" => "N",
            //ISO
            "\xb1" => "a", "\xa1" => "A", "\xe6" => "c", "\xc6" => "C",
            "\xea" => "e", "\xca" => "E", "\xb3" => "l", "\xa3" => "L",
            "\xf3" => "o", "\xd3" => "O", "\xb6" => "s", "\xa6" => "S",
            "\xbc" => "z", "\xac" => "Z", "\xbf" => "z", "\xaf" => "Z",
            "\xf1" => "n", "\xd1" => "N",
            "-" => "", " " => ""
        );

        return strtr($value, $data);
    }

    /**
     * Get class name from object or namespace string
     *  
     * @param mixed $object
     * @param boolean $lower
     * @return string 
     */
    public static function getClassName($object, $lower = false)
    {
        $namespace = $name = $temp = null;

        // for objects
        if (is_object($object)) {

            $reflection = new \ReflectionClass($object);

            if ($reflection->inNamespace()) {

                $namespace = $reflection->getNamespaceName();
                $name = str_replace($namespace . '\\', '', $reflection->getName());
            }
            
        } else { // for string namespaces
            if (!stripos($object, '\\') and !is_string($object)) {
                throw new \InvalidArgumentException("Wrong namespace string");
            }

            $temp = explode('\\', $object);
            $name = $temp[count($temp) - 1];
        }

        return ($lower) ? mb_convert_case($name, MB_CASE_LOWER) : $name;
    }

    /**
     * Get array with error messages
     * 
     * @param Form $form
     * @return array 
     */
    public static function getErrorMessages(Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = strtr($error->getMessageTemplate(), $error->getMessageParameters());
        }

        if ($form->hasChildren()) {
            foreach ($form->getChildren() as $child) {
                if (!$child->isValid()) {
                    $errors[$form->getName().'_'.$child->getName()] = self::getErrorMessages($child);
                }
            }
        }
        return $errors;
    }

}
