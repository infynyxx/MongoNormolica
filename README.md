MongoNormolica
===============
PHP library for managing MongoDB Master-Slave Replication (Normal Replication)

Slaves / Readable Nodes can be selected in different ways:

* **NormolicaRandomSlaveSelector** Select nodes in random way using [mt_rand()](http://us2.php.net/mt_rand)
* **NormolicaRecentlyUsedSlaveSelector** Select most recently used node
* **NormolicaRoundRobinSlaveSelector** Select nodes based on round-robin way

See examples folder for usage

