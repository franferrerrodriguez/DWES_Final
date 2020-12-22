<?php

class OrderLine {

    private $id;
    private $articleId;
    private $quantity;
    private $orderId;
    
    function __construct($articleId, $quantity, $orderId) {
        $this->articleId = $articleId;
        $this->quantity = $quantity;
        $this->orderId = $orderId;
    }

    public function getId() {
        return $this->id;
    }

    public function getArticleId($articleId) {
        $this->articleId = $articleId;
    }

    public function setArticleId() {
        return $this->articleId;
    }

    public function getQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setQuantity() {
        return $this->quantity;
    }

    public function getOrderId($orderId) {
        $this->orderId = $orderId;
    }

    public function setOrderId() {
        return $this->orderId;
    }

}

?>