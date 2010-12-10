<?php
class NormolicaRandomSlaveSelector extends NormolicaSlaveSelector {
    protected function doSelection() {
        $last_index = count($this->slaveNodes) - 1;
        $index = mt_rand(0, $last_index);
        $this->selectedSlave = $this->slaveNodes[$index];
        return $this;
    }
}

