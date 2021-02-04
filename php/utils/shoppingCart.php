<?php

require_once("../utils/globalFunctions.php");
require_once("../class/Article.class.php");
require_once("../class/Order.class.php");
require_once("../class/OrderLine.class.php");
require_once("../class/User.class.php");

$action = $_REQUEST['action'];

$user = User::getUserSession();
$user_id = null;
if(!is_null($user)) {
    $user_id = $user->getId();
}

if($action === "addItem") {
    $articleId = $_REQUEST['id'];
    $article = Article::getById($articleId);
    $quantity = 1;
    if(isset($_REQUEST['quantity'])) {
        $quantity = $_REQUEST['quantity'];
    }
    
    $price = $article->getPrice();
    $price_discount = $article->getPriceDiscount();
    $percentage_discount = $article->getPercentageDiscount();
    if($price_discount) {
        $price = $price_discount;
    } else if($percentage_discount) {
        $price = round(($price - (($price * $percentage_discount) / 100)), 2);
    }
    
    // Recuperamos el pedido
    $order = Order::getMapCookieShoppingCart();

    // Añadimos la nueva línea al pedido
    $order->setOrderLine(new OrderLine($articleId, $article->getName(), $article->getImgRoute(), $article->getFreeShipping(), $quantity, $price));

    $order->updateOrderSessionCookiesIntoDB();
    
    // Seteamos la Cookie
    setcookie("shopping_cart", json_encode_all($order), time() + 3600, "/");
    
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if($action === "updateQuantity") {
    $order = Order::getMapCookieShoppingCart();

    foreach ($order->getOrderLines() as $index => $orderLine) {
        if($orderLine->getArticleId() === $_POST['articleId']) {
            $orderLine->setQuantity($_POST['quantity']);
        }
    }

    $order->refreshOrder();
    
    $order->updateOrderSessionCookiesIntoDB();

    // Actualizamos la Cookie
    setcookie("shopping_cart", json_encode_all($order), time() + 3600, "/");

    echo json_encode_all($order);
} else if($action === "deleteItem") {
    $order = Order::getMapCookieShoppingCart();

    $tmp_orderLines = [];
    foreach ($order->getOrderLines() as $index => $orderLine) {
        if($orderLine->getArticleId() !== $_POST['articleId']) {
            array_push($tmp_orderLines, $orderLine);
        }
    }
    $order->setOrderLines($tmp_orderLines);

    $order->updateOrderSessionCookiesIntoDB();

    // Actualizamos la Cookie
    setcookie("shopping_cart", json_encode_all($order), time() + 3600, "/");

    echo "OK";
} else if($action === "deleteItems") {
    // Si el usuario logado tiene carrito en BBDD, lo eliminamos
    $order = Order::getOrderSessionDB();
    if(!is_null($order)) {
        $order->delete();
    }

    unset($_COOKIE["shopping_cart"]);
    setcookie("shopping_cart", json_encode_all(new Order($user_id)), time() + 3600, "/");
    header('Location: ../../?page=' . $default_page);
}

?>