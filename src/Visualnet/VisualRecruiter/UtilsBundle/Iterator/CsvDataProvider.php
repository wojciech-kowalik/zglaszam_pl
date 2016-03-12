<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Iterator;

/**
 * Data provider iterator
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UtilsBundle\Iterator
 * @access public
 * @copyright visualnet.pl
 */
final class CsvDataProvider implements \Iterator
{
    /**
     * Handle to file
     * @var File 
     */
    protected $file;

    /**
     * Key iterator
     * @var integer
     */
    protected $key = 0;

    /**
     * Current value
     * @var mixed
     */
    protected $current;

    /**
     * Constructor 
     * @param string $file 
     */
    public function __construct($file)
    {
        $this->file = fopen($file, 'r');
    }

    /**
     * Destructor 
     */
    public function __destruct()
    {
        fclose($this->file);
    }

    /**
     * Rewind iterator data 
     */
    public function rewind()
    {
        rewind($this->file);
        $this->current = fgetcsv($this->file);
        $this->key = 0;
    }

    /**
     * Check if isn`t end of file
     */
    public function valid()
    {
        return !feof($this->file);
    }

    /**
     * Get key value
     * @return integer 
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Get current value
     * @return mixed
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * Set to next value 
     */
    public function next()
    {
        $this->current = fgetcsv($this->file);
        $this->key++;
    }

}
