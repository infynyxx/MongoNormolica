<?php
class NormolicaRecentlyUsedSlaveSelector extends NormolicaSlaveSelector {
    private static $recentSlave = null;

    protected function doSelection() {
        if (!self::$recentSlave instanceof Mongo) {
            $slaveSelectorObj = new NormolicaRandomSlaveSelector();
            $slaveSelectorObj->setSlaveNodes($this->slaveNodes);
            self::$recentSlave = $slaveSelectorObj->getSelectedSlave();
        }        
        $this->selectedSlave = self::$recentSlave;
        return $this;
    }
}

