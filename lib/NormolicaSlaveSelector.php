<?php
abstract class NormolicaSlaveSelector {
    /**
     * @returntype array
    **/
    protected  $slaveNodes;

    protected $selectedSlave;

    public function __construct() {
    }

    public function setSlaveNodes(array $slaveNodes) {
        $this->slaveNodes = $slaveNodes;
        return $this;
    }

    public function getSelectedSlave() {
        $this->doSelection();
        return $this->selectedSlave;
    }

    protected abstract function doSelection();
}

