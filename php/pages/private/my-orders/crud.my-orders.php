<?php

require_once('../../../class/Order.class.php');

$action = $_POST["action"];
$id = $_POST["id"];

try {
    $order = Order::getById($id);

    if($action === "cancel") {
        $order->setStatus(Order::CALCELLED);
    } else if($action === "return") {
        $order->setStatus(Order::RETURNED);
    } else if($action === "reorder") {
        $order->setStatus(Order::PROCESSED);
    } 
    
    $order->update();
    
    echo "OK";
} catch(Exception $e) {
    echo "KO";
}

?>