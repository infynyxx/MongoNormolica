<?php
class NormolicaRandomSlaveSelector extends NormolicaSlaveSelector {
    protected function doSelection() {
        if (count($this->slaveNodes) > 0) {
            $last_index = count($this->slaveNodes) - 1;
            $index = mt_rand(0, $last_index);
            $this->selectedSlave = $this->slaveNodes[$index];
        }
        else {
            $this->selectedSlave = null;
        }
        return $this;
    }
}

