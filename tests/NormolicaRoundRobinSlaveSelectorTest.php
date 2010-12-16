<?php

require_once "_autoload.php";

class NormolicaRoundRobinSlaveSelectorTest extends PHPUnit_Framework_TestCase {
    
    protected function setUp() {
        $slave1 = new Mongo("mongodb://localhost:7000", array('connect' => false));
        $slave2 = new Mongo("mongodb://localhost:7001", array('connect' => false));
        $slave3 = new Mongo("mongodb://localhost:7002", array('connect' => false));
        $slave4 = new Mongo("mongodb://localhost:7003", array('connect' => false)); 

        $this->slaveNodes = array($slave1, $slave2, $slave3, $slave4);

        $this->slaveSelector = new NormolicaRoundRobinSlaveSelector();
    }

    public function testSlaveNodesAreAccessedInSequence() {
        $this->slaveSelector->setSlaveNodes($this->slaveNodes);
        $current_port = 7000;
        for ($i = 0; $i < count($this->slaveNodes); $i++) {
            $mongo = $this->slaveSelector->getSelectedSlave();
            $expected_conn_str = "[localhost:{$current_port}]";
            $this->assertEquals($expected_conn_str, $mongo->__toString());
            $current_port++;
        }
    }

    public function testSetSlaveNodesWhenEmpty() {
        $this->slaveNodes = array();
        $this->slaveSelector->setSlaveNodes($this->slaveNodes);
        $this->assertNull($this->slaveSelector->getSelectedSlave());
    } 
}
