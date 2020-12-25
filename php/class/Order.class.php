<?php

require_once('db/db.class.php');
require_once('OrderLine.class.php');
require_once('User.class.php');
require_once('common/Enum.class.php');

class Order {

    private $id;
    private $userId;
    private $status;
    private $orderLines;
    private $totalQuantity;
    private $totalPrice;
    private $freeShipping;
    private $date;
    
    function __construct($userId = null) {
        $this->userId = $userId;
        $this->status = ShoppingCartState::SESSION;
        $this->orderLines = [];
        $this->totalQuantity = 0;
        $this->totalPrice = 0;
        $this->freeShipping = false;
        $this->date = null;
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

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    static function getMapCookieShoppingCart() {
        $user = User::getUserSession();
        $user_id = null;
        if(!is_null($user)) {
            $user_id = $user->getId();
        }

        $o = Order::getOrderSessionDB();
        if(is_null($o) && !isset($_COOKIE["shopping_cart"])) {
            $o = new Order($user_id);
        } else if(is_null($o) && isset($_COOKIE["shopping_cart"])) {
            $order = json_decode($_COOKIE["shopping_cart"]);
            $o = new Order($order->userId);
            foreach ($order->orderLines as $index => $orderLine) {
                $o->setOrderLine(new OrderLine($orderLine->articleId, $orderLine->articleName, 
                    $orderLine->articleImgRoute, $orderLine->freeShipping, $orderLine->quantity, 
                    $orderLine->price, $orderLine->orderId));
            }
        } else {
            $o->setUserId($user_id);
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

        $this->updateSessionIntoDB();
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
                $orderLines = OrderLine::getAllByOrderId($value['id']);
                $records[$index]['orderLines'] = $orderLines;
            }

            return $records;
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    static function getAllByUserId() {
        try {
            $user = User::getUserSession();
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * from ORDERS where user_id = :userId AND status != 0");
                $stmt->execute(array(
                    ':userId' => $user->getId()
                ));
                $stmt->execute();
                $records = $stmt->fetchAll();
            }
            $db->cerrarConn();

            foreach ($records as $index => $value) {
                $orderLines = OrderLine::getAllByOrderId($value['id']);
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
                    $object->status = $r['status'];
                    $object->totalQuantity = $r['total_quantity'];
                    $object->totalPrice = $r['total_price'];
                    $object->freeShipping = $r['free_shipping'];
                    $object->date = $r['date'];

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

    static function getByUserId($userId) {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * FROM ORDERS WHERE user_id = :userId");
                $stmt->execute(array(
                    ':userId' => $userId
                ));
                $stmt->execute();
                $records = $stmt->fetchAll();
                if($records) {
                    $r = $records[0];
                    $object = new Order($userId);
                    $object->id = $r['id'];
                    $object->status = $r['status'];
                    $object->totalQuantity = $r['total_quantity'];
                    $object->totalPrice = $r['total_price'];
                    $object->freeShipping = $r['free_shipping'];
                    $object->date = $r['date'];

                    $orderLines = OrderLine::getAllByOrderId($object->id);
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

    static function getOrderSessionDB() {
        try {
            $records = null;

            if(session_id() == '') {
                session_start();
            }
    
            // Si existe usuario logueado, actualizamos pedido en base de datos
            if(isset($_SESSION["current_session"])) {
                $current_session = $_SESSION["current_session"];
                $userId = $current_session["id"];

                $db = new DB();
                if(!empty($db->conn)) {
                    $stmt = $db->conn->prepare("SELECT * FROM ORDERS WHERE user_id = :userId AND status = " . ShoppingCartState::SESSION);
                    $stmt->execute(array(
                        ':userId' => $userId
                    ));
                    $stmt->execute();
                    $records = $stmt->fetchAll();
                    
                    if($records) {
                        $r = $records[0];
                        $object = new Order($userId);
                        $object->id = $r['id'];
                        $object->status = $r['status'];
                        $object->totalQuantity = $r['total_quantity'];
                        $object->totalPrice = $r['total_price'];
                        $object->freeShipping = $r['free_shipping'];
                        $object->date = $r['date'];
                        
                        $orderLines = OrderLine::getAllByOrderId($object->id);
                        $object->orderLines = $orderLines;

                        return $object;
                    } else {
                        return null;
                    }
                }
                $db->cerrarConn();
            }

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
                    "INSERT INTO ORDERS(status, total_quantity, total_price, free_shipping, date, user_id) VALUES
                    (:status, :totalQuantity, :totalPrice, :freeShipping, :date, :userId)"
                );
        
                $stmt->execute(array(
                    ':status' => $this->status,
                    ':totalQuantity' => $this->totalQuantity,
                    ':totalPrice' => $this->totalPrice,
                    ':freeShipping' => $this->freeShipping,
                    ':date' => $this->date,
                    ':userId' => $this->userId
                ));
            }
            
            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function updateSessionIntoDB() {
        try {
            if(session_id() == '') {
                session_start();
            }
    
            // Si existe usuario logueado
            if(isset($_SESSION["current_session"])) {
                $current_session = $_SESSION["current_session"];
                $user_id = $current_session["id"];
    
                // Eliminamos el pedido actual de BBDD en sesión
                Order::deleteSessionByUserId($user_id);

                // Guardamos el pedido actual obtenido de COOKIES
                $this->setUserId($user_id);
                $this->save();

                // Obtenemos el pedido que acabamos de guardar
                $order = Order::getOrderSessionDB();
                
                // Volvemos a añadir las lineas actuales
                foreach ($this->orderLines as $index => $orderLine) {
                    $orderLine->setOrderId($order->getId());
                    $orderLine->save();
                }
            }
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function delete() {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "DELETE FROM ORDERS WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    ':id' => $this->id
                ));
            }

            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    static function deleteSessionByUserId($userId) {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "DELETE FROM ORDERS WHERE user_id = :userId AND status = " . ShoppingCartState::SESSION
                );
        
                $stmt->execute(array(
                    ':userId' => $userId
                ));
            }

            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

}

?>