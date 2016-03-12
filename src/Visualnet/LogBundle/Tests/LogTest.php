<?php

namespace Visualnet\LogBundle\Tests;

use Visualnet\LogBundle\Model;
use Visualnet\LogBundle\Extras\LogContent;
use Visualnet\LogBundle\Enum\Type;
use Visualnet\UserBundle\Model as UserModel;
use Symfony\Component\HttpFoundation\Request;

require_once(__DIR__ . "/../../../../app/AppKernel.php");

class LogTest extends \PHPUnit_Framework_TestCase
{

    private $_log;
    protected $_container;

    public function __construct()
    {
        $kernel = new \AppKernel("test", true);
        $kernel->boot();
        $this->_container = $kernel->getContainer();
        parent::__construct();
    }

    protected function setUp()
    {
        $this->_log = $this->_container->get("log");
    }

    public function testSave()
    {
        $firstContent = new LogContent();

        $firstContent->content = "test";
        $firstContent->message = "testing message";
        $firstContent->type = Type::NOTICE;
        
        $this->assertEquals($this->_log->save(new Request, $firstContent), true);

        $secondContent = clone($firstContent);
        $secondContent->ip = "127.0.0";
        $secondContent->type = Type::ERROR;
        
        $this->assertEquals($this->_log->save(new Request, $secondContent), true);
        
    }

    protected function tearDown()
    {
        
    }

}
?>
