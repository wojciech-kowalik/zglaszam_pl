<?php

namespace Visualnet\VisualRecruiter\UtilsBundle\Tests\Helper;

use Visualnet\VisualRecruiter\UtilsBundle\Helper\String;
use Visualnet\VisualRecruiter\UtilsBundle\Iterator;

class StringTest extends \PHPUnit_Framework_TestCase
{

    public static function setUpBeforeClass(){} // setup method for all test suite
    protected function setUp(){} // setup method for each method in test suite
    
    protected function tearDown(){} // destruct method for all test suite
    public static function tearDownAfterClass(){} // destruct method for each method in test suite

    public function provider()
    {
        return new Iterator\CsvDataProvider(__DIR__ . "/../../Resources/test/slugify.csv");
    }

    /**
     * @dataProvider provider
     */
    public function testSlugify($x, $y)
    {
        $this->assertEquals(String::slugify($x), $y);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testException()
    {
        $this->assertEquals(String::slugify(12), 12);
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * @depends testSlugify
     */
    public function testSummary()
    {
        //fwrite(STDOUT, "\nEND OF TEST");
        $this->markTestSkipped("\nEND OF TEST");        
    }

}
