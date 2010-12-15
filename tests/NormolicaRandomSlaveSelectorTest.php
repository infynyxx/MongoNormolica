<?php

require_once "_autoload.php";

class NormolicaRandomSlaveSelectorTest extends PHPUnit_Framework_TestCase {
    
    protected function setUp() {
        //For ease of testing perform lazy connection
        $slave1 = new Mongo("mongodb://localhost:7000", array('connect' => false));
        $slave2 = new Mongo("mongodb://localhost:7001", array('connect' => false));

        $this->slaveNodes = Array($slave1,$slave2);
        $this->slaveSelector = new NormolicaRandomSlaveSelector();
    }

    public function testSetSlaveNodesWhenEmpty() {
        $this->slaveNodes = array();
        $this->slaveSelector->setSlaveNodes($this->slaveNodes);
        $this->assertNull($this->slaveSelector->getSelectedSlave());    
    }
    
    public function testGetSelectedSlave() {
        $this->slaveSelector->setSlaveNodes($this->slaveNodes);
        $this->assertInstanceOf('Mongo', $this->slaveSelector->getSelectedSlave());
    }

    public function testSingleSlaveAlwaysReturnSameConnection() {
        $expected_port = 7000;
        $expected_host = "localhost";

        $single_slave_array = array(new Mongo("mongodb://{$expected_host}:{$expected_port}", array('connect' => false)));
        $this->slaveSelector->setSlaveNodes($single_slave_array); 
        $mongo = $this->slaveSelector->getSelectedSlave();
        $this->assertEquals("[".$expected_host.":".$expected_port."]", $mongo->__toString());
    }
}
