<?php

require_once('db/db.class.php');
require_once('OrderLine.class.php');
require_once('User.class.php');

class Order {

    // Order Status
    const SESSION = 0;
    const PROCESSED = 1;
    const CALCELLED = 2;
    const RETURNED = 3;

    private $id;
    private $userId;
    private $status;
    private $orderLines;
    private $totalQuantity;
    private $totalPrice;
    private $freeShipping;
    private $date;
    private $paidMethod;
    
    function __construct($userId = null) {
        $this->userId = $userId;
        $this->status = Order::SESSION;
        $this->orderLines = [];
        $this->totalQuantity = 0;
        $this->totalPrice = 0;
        $this->freeShipping = 0;
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

    public static function getStatusText($status) {
        switch ($status) {
            case Order::SESSION:
                return "NO PROCESADO";
            case Order::PROCESSED:
                return "PROCESADO";
            case Order::CALCELLED:
                return "CANCELADO";
            case Order::RETURNED:
                return "EN DEVOLUCIÓN";
        }
    }

    public static function getStatusColor($status) {
        switch ($status) {
            case Order::SESSION:
                return "secondary";
            case Order::PROCESSED:
                return "success";
            case Order::CALCELLED:
                return "danger";
            case Order::RETURNED:
                return "warning";
        }
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

    public function setPaidMethod($paidMethod) {
        $this->paidMethod = $paidMethod;
    }

    public function getPaidMethod() {
        return $this->paidMethod;
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
                $o->updateSessionIntoDB();
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
    }

    // Obtiene todos los pedidos
    static function getAll() {
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
    }

    static function getById($id) {
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
                $object->paidMethod = $r['paid_method'];

                $orderLines = OrderLine::getAllByOrderId($id);
                //$object->setOrderLines($orderLines);
                    
                return $object;
            } else {
                return null;
            }
        }
        $db->cerrarConn();
        return $records;
    }

    // Obtiene de la BBDD los pedidos de un usuario
    static function getAllByUserId() {
        $user = User::getUserSession();
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from ORDERS where user_id = :userId");
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
    }

    // Obtiene de la BBDD el pedido que todavía no ha sido finalizado (En estado sesión)
    static function getOrderSessionDB() {
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
                $stmt = $db->conn->prepare("SELECT * FROM ORDERS WHERE user_id = :userId AND status = " . Order::SESSION);
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
                    $object->paidMethod = $r['paid_method'];
                    
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
    }

    // Obtiene de la BBDD los pedidos que han sido finalizados
    static function getFinishedByUserId() {
        $user = User::getUserSession();
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from ORDERS where user_id = :userId AND status != :status");
            $stmt->execute(array(
                ':userId' => $user->getId(),
                ':status' => Order::SESSION
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
    }

    function save() {
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
    }

    function update() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "UPDATE ORDERS 
                SET status = :status, free_shipping = :freeShipping, date = :date, paid_method = :paidMethod
                WHERE id LIKE :id"
            );
    
            $stmt->execute(array(
                ':id' => $this->id,
                ':status' => $this->status,
                ':freeShipping' => $this->freeShipping,
                ':date' => $this->date,
                ':paidMethod' => $this->paidMethod
            ));
        }

        $db->cerrarConn();
    }

    function updateSessionIntoDB() {
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
            $this->setFreeShipping(0);
            $this->save();

            // Obtenemos el pedido que acabamos de guardar
            $order = Order::getOrderSessionDB();
            
            // Volvemos a añadir las lineas actuales
            foreach ($this->orderLines as $index => $orderLine) {
                $orderLine->setOrderId($order->getId());
                $orderLine->save();
            }
        }
    }

    function delete() {
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
    }

    static function deleteSessionByUserId($userId) {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "DELETE FROM ORDERS WHERE user_id = :userId AND status = " . Order::SESSION
            );
    
            $stmt->execute(array(
                ':userId' => $userId
            ));
        }

        $db->cerrarConn();
    }

}

?>