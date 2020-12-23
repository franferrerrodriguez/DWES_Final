<?php

require_once('OrderLine.class.php');
require_once('common/Enum.class.php');

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
        $this->status = ShoppingCartState::SESSION;
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
        $this->refreshOrder();
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
        $this->refreshOrder();
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
        } else {
            if(session_id() == '') {
                session_start();
            }
            
            // Recuperamos el usuario
            $user_id = null;
            if(isset($_SESSION["current_session"])) {
                $current_session = $_SESSION["current_session"];
                $user_id = $current_session["id"];
            }

            setcookie("shopping_cart", json_encode_all(new Order($user_id)), time() + 3600, "/");
            $o = json_decode($_COOKIE["shopping_cart"]);
        }
        return $o;
    }

    function refreshOrder() {
        $this->totalQuantity = 0;
        $this->totalPrice = 0;
        $this->freeShipping = false;
        foreach ($this->orderLines as $index => $orderLine) {
            $orderLine->setTotalPrice(round($orderLine->getQuantity() * $orderLine->getPrice(), 2));
            $this->totalQuantity += $orderLine->getQuantity();
            $this->totalPrice += $orderLine->getTotalPrice();
            if(!$this->freeShipping) {
                $this->freeShipping = $orderLine->getFreeShipping();
            }
        }
        $this->totalPrice = round($this->totalPrice, 2);

        if(session_id() == '') {
            session_start();
        }
        
        // Si existe usuario logueado, actualizamos pedido en base de datos
        if(isset($_SESSION["current_session"])) {
            $current_session = $_SESSION["current_session"];
            $user_id = $current_session["id"];




            //echo "UPDATE SC";
        }

    }

    static function getAll() {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * from ORDERS");
                $stmt->execute();
                $records = $stmt->fetchAll();
            }
            $db->cerrarConn();

            foreach ($records as $index => $value) {
                $orderLines = OrderLine::getOrderLineByOrder($value['id']);
                $records[$index]['orderLines'] = $orderLines;
            }

            return $records;
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    static function getById($id) {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * FROM ORDERS WHERE id = :id");
                $stmt->execute(array(
                    ':id' => $id
                ));
                $stmt->execute();
                $records = $stmt->fetchAll();
                if($records) {
                    $r = $records[0];
                    $object = new Order($r['user_id']);
                    $object->id = $id;
                    $orderLines = OrderLine::getAllByOrderId($id);
                    $object->setOrderLines($orderLines);
                        
                    return $object;
                } else {
                    return null;
                }
            }
            $db->cerrarConn();
            return $records;
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function save() {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "INSERT INTO ORDERS(status, total_quantity, total_price, free_shipping, user_id) VALUES
                    (:status, :totalQuantity, :totalPrice, :freeShipping, :userId)"
                );
        
                $stmt->execute(array(
                    ':status' => $this->status,
                    ':totalQuantity' => $this->totalQuantity,
                    ':totalPrice' => $this->totalPrice,
                    ':freeShipping' => $this->freeShipping,
                    ':userId' => $this->userId
                ));
            }
            
            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function update($session = false) {
        try {
            $db = new DB();

            if($session) {
                $where = "user_id LIKE :id AND status = " . ShoppingCartState::SESSION;
            } else {
                $where = "id LIKE :id";
            }

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "UPDATE ORDERS SET status = :status, total_quantity = :totalQuantity, total_price = :totalPrice, 
                    free_shipping = :freeShipping, user_id = :userId
                    WHERE $where"
                );
        
                $stmt->execute(array(
                    ':id' => $this->id,
                    ':status' => $this->status,
                    ':totalQuantity' => $this->totalQuantity,
                    ':totalPrice' => $this->totalPrice,
                    ':freeShipping' => $this->freeShipping,
                    ':userId' => $this->userId
                ));

                // Eliminamos las lineas relacionadas

                // Añadimos las lineas actuales
            }
            
            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    static function delete($id) {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "DELETE FROM ORDERS WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    ':id' => $id
                ));
            }

            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }











}

?>