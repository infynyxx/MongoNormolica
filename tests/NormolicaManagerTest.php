<?php
require_once "_autoload.php";

/**
 * Tests for NormolicaManager
 * @author Prajwal Tuladhar
 * @copyright 2010 Prajwal Tuladhar <praj@infynyxx.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link https://github.com/infynyxx/MongoNormolica
**/

class NormolicaManagerTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->instance = NormolicaManager::instance();
    }
    
    /**
     * @covers Normolica::instance
    **/
    public function testNormolicaManagerInstanceIsSingleton() {
        $expected = 10;

        $instance1 = NormolicaManager::instance();
        $instance1->test_property = $expected;
        $instance2 = NormolicaManager::instance();
        $this->assertEquals($expected, $instance2->test_property);

        $expected = 200;
        $instance2->test_property = $expected;
        $this->assertEquals($expected, $instance1->test_property);
    }


    /**
     * @covers NormolicaManager::getWriteServer
    **/
    public function testGetWriteServer() {
        $mongo_connection1 = new Mongo("mongodb://localhost:7000", array('connect' => false));
        $mongo_connection2 = new Mongo("mongodb://localhost:7001", array('connect' => false));
        $mongo_connection3 = new Mongo("mongodb://localhost:7002", array('connect' => false));
        $mongo_connection4 = new Mongo("mongodb://localhost:7003", array('connect' => false));

        $this->instance->add($mongo_connection1, NormolicaManager::MODE_READ_WRITE);
        $this->instance->add($mongo_connection2, NormolicaManager::MODE_READ);
        $this->instance->add($mongo_connection3, NormolicaManager::MODE_READ);
        $this->instance->add($mongo_connection4, NormolicaManager::MODE_READ);

        $expected_write_master_to_string = "[localhost:7000]";

        $this->assertEquals($expected_write_master_to_string, $this->instance->getWriteServer()->__toString());
    }

    
    /**
     * @covers NormolicaManager::getReadServer
     * @covers NormolicaManager::setSlaveSelectorMode
    **/
    public function testGetReadServer() {
        $mongo_connection1 = new Mongo("mongodb://localhost:7000", array('connect' => false));
        $mongo_connection2 = new Mongo("mongodb://localhost:7001", array('connect' => false));
        $mongo_connection3 = new Mongo("mongodb://localhost:7002", array('connect' => false));
        $mongo_connection4 = new Mongo("mongodb://localhost:7003", array('connect' => false));

        $this->instance->add($mongo_connection1, NormolicaManager::MODE_READ_WRITE);
        $this->instance->add($mongo_connection2, NormolicaManager::MODE_READ);
        $this->instance->add($mongo_connection3, NormolicaManager::MODE_READ);
        $this->instance->add($mongo_connection4, NormolicaManager::MODE_READ);

        //Since we have 4 read nodes, we are going to use RoundRobin to select read server and for each iteration it should be uniquea
        $used_ports = array(7000, 7001, 7002, 7003);
        $this->instance->setSlaveSelectorMode(new NormolicaRoundRobinSlaveSelector());
        for ($i = 0; $i < count($used_ports); $i++) {
            $expected = "[localhost:{$used_ports[$i]}]";
            $this->assertEquals($expected, $this->instance->getReadServer()->__toString());
        }
 
    }
}
