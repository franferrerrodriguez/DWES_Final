<?php
require_once('../utils/globalFunctions.php');
require_once('../class/Order.class.php');

if(session_id() == '') {
    session_start();
}

// Si cerramos sesión y existe pedido en BBDD, vaciamos las COOKIES para el usuario anónimo
$order = Order::getOrderSessionDB();
if(!is_null($order)) {
    unset($_COOKIE["shopping_cart"]);
    setcookie("shopping_cart", "", time() + 3600, "/");
}

unset($_SESSION['current_session']);
header("Location: ../../?page=" . $default_page);
?>