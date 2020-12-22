<?php

class Order {

    private $id;
    private $customerId;
    private $status;
    private $orderLines;
    
    function __construct($customerId = null) {
        $this->customerId = $customerId;
        $this->status = "SESSION";
        $this->orderLines = [];
    }
    
    public function getId() {
        return $this->id;
    }

    public function getCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    public function setCustomerId() {
        return $this->customerId;
    }

    public function getStatus($status) {
        $this->status = $status;
    }

    public function setStatus() {
        return $this->status;
    }

    public function getOrderLines($orderLines) {
        $this->orderLines = $orderLines;
    }

    public function setOrderLines() {
        return $this->orderLines;
    }

}

?>