<?
class NormolicaMongoCollection extends MongoCollection {

    protected $dbName;

    public static $forceMaster = false;

    public function __construct(NormolicaMongoDB $mongodb, $name) {
        parent::__construct($mongodb, $name);
        $this->dbName = $this->db->__toString();
    }

    private function currentSlave() {
        $slave = NormolicaManager::instance()->getReadServer()->selectDB($this->dbName);
        $collection = $this->getName();
        return $slave->$collection;
    }

    public function find(array $query=array(), array $fields=array())  {
        return (self::$forceMaster === false) ? $this->currentSlave()->find($query, $fields) : 
                                                parent::find($query, $fields);
    }

    public function findOne(array $query=array(), array $fields=array()) {
        return (self::$forceMaster === false) ? $this->currentSlave()->findOne($query, $fields) : parent::findOne($query, $fields);
    }

    public function group($keys, array $initial, MongoCode $reduce, array $options=array()) {
        return (self::$forceMaster === false) ? $this->currentSlave()->group($keys, $initial, $reduce, $options) :
                                                parent::group($keys, $initial, $reduce, $options);
    }
    
}
