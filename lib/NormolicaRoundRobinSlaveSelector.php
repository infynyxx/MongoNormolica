<?php
class NormolicaRoundRobinSlaveSelector extends NormolicaSlaveSelector {
    private static $currentIndex = -1;  //not started yet

    protected function doSelection() {
        $size = count($this->slaveNodes);
        $lastIndex = $size - 1;
        if (self::$currentIndex < $lastIndex || self::$currentIndex === -1) {
            self::$currentIndex++;
        }
        else if (self::$currentIndex == $lastIndex) {
            self::$currentIndex = 0;
        }
        $this->selectedSlave = $this->slaveNodes[self::$currentIndex];
        return $this;
    }
}

