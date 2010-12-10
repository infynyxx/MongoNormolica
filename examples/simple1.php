<?php

include '_autoload.php';

NormolicaManager::instance()
    ->add(new Mongo('mongodb://localhost:7000'), 'RW')
    ->add(new Mongo('mongodb://localhost:7001'), 'R')
    ->add(new Mongo('mongodb://localhost:7002'), 'R')
    ->setSlaveSelectorMode(new NormolicaRandomSlaveSelector());

//var_dump(NormolicaManager::instance()->getWriteServer());

var_dump(NormolicaManager::instance()->getReadServer());

var_dump(NormolicaManager::instance()->getReadServer());

var_dump(NormolicaManager::instance()->getReadServer());die();

NormolicaMongoCollection::$forceMaster = true;

$c = new NormolicaMongoCollection(new NormolicaMongoDB('test_db'), 'test_collection');
$cursor = $c->find();

foreach ($cursor as $arr) {
    print_r($arr);
}
