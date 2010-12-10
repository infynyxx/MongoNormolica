<?php
class NormolicaRecentlyUsedSlaveSelector extends NormolicaSlaveSelector {
    private static $recentSlave = null;

    protected function doSelection() {
        if (!self::$recentSlave instanceof Mongo) {
            $slaveSelectorObj = new NormolicaRandomSlaveSelector($this->slaveNodes);
            self::recentSlave = $slaveSelectorObj->getSelectedSlave();
        }        
        return self::$recentSlave;
    }
}

