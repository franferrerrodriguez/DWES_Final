<?php

require_once('db/db.class.php');

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

    function __construct($articleId, $articleName, $articleImgRoute, $freeShipping, $quantity, $price, $orderId = null) {
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

    public function setOrderId($orderId) {
        $this->orderId = $orderId;
    }

    public function getOrderId() {
        return $this->orderId;
    }

    public function setFreeShipping($freeShipping) {
        $this->freeShipping = $freeShipping;
    }

    public function getFreeShipping() {
        return $this->freeShipping;
    }

    static function getAllByOrderId($orderId) {
            $records = null;
            $orderLines = [];
            
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * from ORDERLINES WHERE order_id = :orderId");
                $stmt->execute(array(
                    ':orderId' => $orderId
                ));
                $stmt->execute();
                $records = $stmt->fetchAll();
                foreach ($records as $index => $value) {
                    $orderLine = new OrderLine($value["article_id"], $value["article_name"], $value["article_img_route"], 
                                               $value["free_shipping"], $value["quantity"], $value["price"], $value["order_id"]);
                    $orderLine->id = $value["id"];
                    array_push($orderLines, $orderLine);
                }
            }
            $db->cerrarConn();

            return $orderLines;
    }

    function save() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "INSERT INTO ORDERLINES(article_name, article_img_route, quantity, price, total_price, 
                free_shipping, article_id, order_id) VALUES
                (:articleName, :articleImgRoute, :quantity, :price, :totalPrice, :freeShipping, :articleId, :orderId)"
            );
    
            $stmt->execute(array(
                ':articleName' => $this->articleName,
                ':articleImgRoute' => $this->articleImgRoute,
                ':quantity' => $this->quantity,
                ':price' => $this->price,
                ':totalPrice' => $this->totalPrice,
                ':freeShipping' => $this->freeShipping,
                ':articleId' => $this->articleId,
                ':orderId' => $this->orderId
            ));
        }
        
        $db->cerrarConn();
    }

    function update() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "UPDATE ORDERLINES 
                SET article_name = :articleName, article_img_route = :articleImgRoute, quantity = :quantity, price = :price, total_price = :totalPrice, free_shipping = :freeShipping, article_id = :articleId, order_id = :orderId
                WHERE id LIKE :id"
            );
    
            $stmt->execute(array(
                ':id' => $this->id,
                ':articleName' => $this->articleName,
                ':articleImgRoute' => $this->articleImgRoute,
                ':quantity' => $this->quantity,
                ':price' => $this->price,
                ':totalPrice' => $this->totalPrice,
                ':freeShipping' => $this->freeShipping,
                ':articleId' => $this->articleId,
                ':orderId' => $this->orderId
            ));
        }

        $db->cerrarConn();
    }
    
    static function delete($id) {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "DELETE FROM ORDERLINES WHERE id LIKE :id"
            );
    
            $stmt->execute(array(
                ':id' => $id
            ));
        }

        $db->cerrarConn();
    }

    static function deleteByOrderId($orderId) {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "DELETE FROM ORDERLINES WHERE order_id LIKE :orderId"
            );
    
            $stmt->execute(array(
                ':orderId' => $orderId
            ));
        }

        $db->cerrarConn();
    }

}

?>