<?php
class NormolicaMongoDB extends MongoDB {
    public function __construct($name) {        
        parent::__construct(NormolicaManager::instance()->getWriteServer(), $name);
    }
}

