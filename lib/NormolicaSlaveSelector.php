<?php
abstract class NormolicaSlaveSelector {
    /**
     * @returntype array
    **/
    protected  $slaveNodes = array();

    protected $selectedSlave;

    public function __construct() {
    }

    public function setSlaveNodes(array $slaveNodes) {
        $this->slaveNodes = $slaveNodes;
        return $this;
    }

    public function getSelectedSlave() {
        if (count($this->slaveNodes) > 0) {
            $this->doSelection();
            return $this->selectedSlave;
        }
        return null;
    }

    protected abstract function doSelection();
}

