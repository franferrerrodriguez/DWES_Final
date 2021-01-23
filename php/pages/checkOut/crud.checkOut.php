<?php

require_once('../../utils/globalFunctions.php');
require_once('../../class/Order.class.php');

$paidMethod = $_POST['paidMethod'];

try {
    $order = Order::getOrderSessionDB();

    // Avanzamos la orden del pedido de sesión
    $order->setPaidMethod($paidMethod);
    $order->setDate(getDateTimeFormat());
    $order->setStatus(Order::PROCESSED);
    $order->update();
    
    // Eliminamos el carrito de las cookies de sesión
    unset($_COOKIE["shopping_cart"]);
    setcookie("shopping_cart", "", time() + 3600, "/");
    
    echo "OK";
} catch(exception $e) {
    echo $e;
}

?>