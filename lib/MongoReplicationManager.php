<?php

class NormolicaManager {

    private static $_connectionManager;

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

    public function add(Mongo $mongoConnection, $mode) {
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
        return ($count === 1) ? self::$connectionArrayRead[0] : mt_rand(0, $count-1);
    }

}



NormolicaManager::instance()
    ->add(new Mongo('mongodb://localhost:270147'), 'RW')
    ->add(new Mongo('mongodb://localhost:27018'), 'W');

//var_dump(NormolicaManager::instance()->getWriteServer());

NormolicaMongoCollection::$forceMaster = true;

$c = new NormolicaMongoCollection(new NormolicaMongoDB('test_db'), 'test_collection');
$cursor = $c->find();

foreach ($cursor as $arr) {
    print_r($arr);
}
