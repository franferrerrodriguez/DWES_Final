<?php

class OrderLine {

    private $id;
    private $articleId;
    private $articleName;
    private $articleImgRoute;
    private $quantity;
    private $price;
    private $totalPrice;
    private $orderId;
    private $freeShipping;

    function __construct($articleId, $articleName, $articleImgRoute, $freeShipping, $quantity, $price, $orderId = "SESSION") {
        $this->articleId = $articleId;
        $this->articleName = $articleName;
        $this->articleImgRoute = $articleImgRoute;
        $this->freeShipping = $freeShipping;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->orderId = $orderId;
        $this->totalPrice = $quantity * $price;
        $this->freeShipping = $freeShipping;
    }

    public function getId() {
        return $this->id;
    }

    public function setArticleId($articleId) {
        $this->articleId = $articleId;
    }

    public function getArticleId() {
        return $this->articleId;
    }

    public function setArticleName($articleName) {
        $this->articleName = $articleName;
    }

    public function getArticleName() {
        return $this->articleName;
    }

    public function setArticleImgRoute($articleImgRoute) {
        $this->articleImgRoute = $articleImgRoute;
    }

    public function getArticleImgRoute() {
        return $this->articleImgRoute;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function getOrderId($orderId) {
        $this->orderId = $orderId;
    }

    public function setOrderId() {
        return $this->orderId;
    }

    public function setFreeShipping($freeShipping) {
        $this->freeShipping = $freeShipping;
    }

    public function getFreeShipping() {
        return $this->freeShipping;
    }

}

?>