<?php

class NormolicaManager {

    private static $_connectionManager;

    private $slaveSelector;

    const MODE_READ = 'R';
    const MODE_WRITE = 'W';
    const MODE_READ_WRITE = 'RW';

    private static $connectionArrayRead = array();
    private static $connectionWrite;

    private function __construct() {}

    public static function instance() {
        if (!self::$_connectionManager instanceof NormolicaManager) {
            self::$_connectionManager = new NormolicaManager();
        }
        return self::$_connectionManager;
    }

    public function add(Mongo $mongoConnection, $mode, $weight = 5) {
        if ($mode == self::MODE_READ_WRITE) {
            self::$connectionWrite = $mongoConnection;
            self::$connectionArrayRead[] = $mongoConnection;
        }
        else if ($mode == self::MODE_WRITE) {
            self::$connectionWrite = $mongoConnection;
        }
        else if ($mode == self::MODE_READ) {            
            self::$connectionArrayRead[] = $mongoConnection;
        }
        return $this;
    }

    public function getWriteServer() {
        return self::$connectionWrite;
    }

    public function getReadServer() {



        $count = count(self::$connectionArrayRead);
        if ($count <= 0) {
            return false;
        }

        if ($count === 1) {
            return self::$connectionArrayRead[0];
        }

        return $this->slaveSelector->getSelectedSlave();
        /**
        else {
            $last_index = $count - 1;
            $index = mt_rand(0, $last_index);
            return self::$connectionArrayRead[$index];
        }
        **/
    }

    public function setSlaveSelectorMode(NormolicaSlaveSelector $slaveSelector) {
        $this->slaveSelector = $slaveSelector;
        $this->slaveSelector->setSlaveNodes(self::$connectionArrayRead);
    }

}
