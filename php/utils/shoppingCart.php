<?php

require_once("../utils/globalFunctions.php");
require_once("../class/Article.class.php");
require_once("../class/Order.class.php");
require_once("../class/OrderLine.class.php");

$action = $_REQUEST['action'];

if(session_id() == '') {
    session_start();
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

    $current_session = null;
    $user_id = null;
    if(isset($_SESSION["current_session"])) {
        $current_session = $_SESSION["current_session"];
        $user_id = $current_session["id"];
    }
    
    // Recuperamos el pedido
    $order = null;
    if(!isset($_COOKIE["shopping_cart"])) {
        $order = new Order($user_id);
    } else {
        $order = Order::getMapCookieShoppingCart();
    }

    // Añadimos la nueva línea al pedido
    $order->setOrderLine(new OrderLine($articleId, $article->getName(), $article->getImgRoute(), $article->getFreeShipping(), $quantity, $price));

    // Seteamos la Cookie
    setcookie("shopping_cart", json_encode_all($order), time() + 3600, "/");
    
    header('Location: /?page=shoppingCart');
} else if($action === "updateQuantity") {
    $order = Order::getMapCookieShoppingCart();

    foreach ($order->getOrderLines() as $index => $orderLine) {
        if($orderLine->getArticleId() === $_POST['articleId']) {
            $orderLine->setQuantity($_POST['quantity']);
        }
    }

    $order->refreshOrder();

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

    // Actualizamos la Cookie
    setcookie("shopping_cart", json_encode_all($order), time() + 3600, "/");

    echo "OK";
} else if($action === "deleteItems") {
    unset($_COOKIE["shopping_cart"]);
    setcookie("shopping_cart", "", time() - 36000, "/");
    header('Location: /?page=index');
}

?>