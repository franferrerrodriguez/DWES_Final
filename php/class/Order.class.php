<?php

require_once('OrderLine.class.php');

class Order {

    private $id;
    private $userId;
    private $status;
    private $orderLines;
    private $totalQuantity;
    private $totalPrice;
    private $freeShipping;
    
    function __construct($userId = null) {
        $this->userId = $userId;
        $this->status = "SESSION";
        $this->orderLines = [];
        $this->totalQuantity = 0;
        $this->totalPrice = 0;
        $this->freeShipping = false;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setOrderLines($orderLines) {
        $this->orderLines = $orderLines;
        $this->updateOrder();
    }

    public function getOrderLines() {
        return $this->orderLines;
    }

    public function setOrderLine($orderLine) {
        $exist = false;
        foreach ($this->orderLines as $index => $_orderLine) {
            if($_orderLine->getArticleId() == $orderLine->getArticleId()) {
                $exist = true;
                $_orderLine->setQuantity($_orderLine->getQuantity() + $orderLine->getQuantity());
            }
        }
        if(!$exist) {
            array_push($this->orderLines, $orderLine);
        }
        $this->updateOrder();
    }

    public function setOrderLineByArticleId($articleId) {
        foreach ($this->orderLines as $index => $orderLine) {
            if($orderLine->getArticleId() == $articleId) {

            }
        }
        return $this->orderLines;
    }

    public function getTotalQuantity() {
        return $this->totalQuantity;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function setFreeShipping($freeShipping) {
        $this->freeShipping = $freeShipping;
    }

    public function getFreeShipping() {
        return $this->freeShipping;
    }

    static function getMapCookieShoppingCart() {
        $o = null;
        if(isset($_COOKIE["shopping_cart"])) {
            $order = json_decode($_COOKIE["shopping_cart"]);
            $o = new Order($order->userId);
            foreach ($order->orderLines as $index => $orderLine) {
                $o->setOrderLine(new OrderLine($orderLine->articleId, $orderLine->articleName, $orderLine->articleImgRoute, $orderLine->freeShipping, $orderLine->quantity, $orderLine->price, $orderLine->orderId));
            }
        }
        return $o;
    }

    function updateOrder() {
        $this->totalQuantity = 0;
        $this->totalPrice = 0;
        $this->freeShipping = false;
        foreach ($this->orderLines as $index => $orderLine) {
            $this->totalQuantity += $orderLine->getQuantity();
            $this->totalPrice += $orderLine->getQuantity() * $orderLine->getPrice();
            if(!$this->freeShipping) {
                $this->freeShipping = $orderLine->getFreeShipping();
            }
        }
    }

}

?>