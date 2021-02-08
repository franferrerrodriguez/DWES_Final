<?php

require_once('../../../../../class/Order.class.php');

$action = $_REQUEST['action'];
$id = $_POST["id"];

if($action === "addEdit") {
    $status = $_POST['status'];
    $paidMethod = $_POST['paidMethod'];
    $freeShipping = $_POST['freeShipping'];

    $order = Order::getById($id);
    $order->setStatus($status);
    $order->setPaidMethod($paidMethod);
    $order->setFreeShipping($freeShipping);
    $orderLines = $order->getOrderLines();
    foreach ($orderLines as $i => $orderLine) {
        $orderLine->setFreeShipping($freeShipping);
        $orderLine->update();
    }

    try {
        $order->update();
        echo "OK";
    } catch (exception $e) {
        echo $e->getMessage();
    }

}

?>