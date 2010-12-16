<?php
require_once "_autoload.php";

class NormolicaRecentlyUsedSlaveSelectorTest extends PHPUnit_Framework_TestCase {
    
    protected function setUp() {
         $slave1 = new Mongo("mongodb://localhost:7000", array('connect' => false));
        $slave2 = new Mongo("mongodb://localhost:7001", array('connect' => false));
        $slave3 = new Mongo("mongodb://localhost:7002", array('connect' => false));
        $slave4 = new Mongo("mongodb://localhost:7003", array('connect' => false)); 

        $this->slaveNodes = array($slave1, $slave2, $slave3, $slave4); 

        $this->slaveSelector = new NormolicaRecentlyUsedSlaveSelector();
    }


    public function testRecentlyUsedSlaveNodeAsSelectedNode() {
        $this->slaveSelector->setSlaveNodes($this->slaveNodes);
        $current_port = 7000;
        $expected_connection_string = "[localhost:{$current_port}]";
        $initial_mongo_connection = $this->slaveSelector->getSelectedSlave();

        for ($i = 0; $i < count($this->slaveNodes); $i++) {
            $selected_mongo_connection = $this->slaveSelector->getSelectedSlave();
            $this->assertEquals($initial_mongo_connection->__toString(), $selected_mongo_connection->__toString());
        }
    }
}
