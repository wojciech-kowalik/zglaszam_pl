<?php

namespace Visualnet\LogBundle\Extras;

use Symfony\Component\Validator\Constraints\IpValidator;

/**
 * Log content
 * 
 * @author w.kowalik 
 * @package Visualnet\LogBundle\Extras
 * @access public
 * @copyright visualnet.pl
 */
class LogContent
{
    /**
     * Attributes array
     * 
     * @var array 
     */
    protected $attributes = array(
        "content" => null,
        "message" => null,
        "ip" => null,
        "type" => null
    );

    /**
     * Attribute setter
     * 
     * @param type $key
     * @param type $value
     * @throws \InvalidArgumentException 
     */
    public function __set($key, $value)
    {
        if (!array_key_exists($key, $this->attributes))
            throw new InvalidArgumentException(sprintf('Class %s dosen`t have attribute: %s', __CLASS__, $key));

        if (method_exists($this, $methodName = 'set' . ucfirst($key)))
            return $this->$methodName($value);

        $this->attributes[$key] = $value;
    }

    /**
     * Attribute getter
     * 
     * @param type $key
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes))
            return $this->attributes[$key];

        throw new \InvalidArgumentException(sprintf('Class %s dosen`t have attribute: %s', __CLASS__, $key));
    }

    /**
     * Set ip
     * 
     * @param type $value
     * @throws \InvalidArgumentException 
     */
    public function setIp($value)
    {
        $validator = new IpValidator();

        if (!$validator->isValid($value, new \Symfony\Component\Validator\Constraints\Ip())) {
            throw new \InvalidArgumentException("Wrong ip number");
        }

        $this->attributes["ip"] = $value;
    }

    /**
     * Set type
     * 
     * @param type $value
     * @throws \InvalidArgumentException 
     */
    public function setType($value)
    {
        $reflection = new \ReflectionClass("Visualnet\LogBundle\Enum\Type");

        if (!in_array($value, $reflection->getConstants())) {
            throw new \InvalidArgumentException("Wrong type");
        }

        $this->attributes["type"] = $value;
    }

    /**
     * Set message
     * 
     * @param type $value
     * @throws \InvalidArgumentException 
     */    
    public function setMessage($value)
    {
        if (empty($value) && !isset($value)) {
            throw new \InvalidArgumentException("Message has to be filled");
        }
        
        $this->attributes["message"] = $value;
    }

}
?>
