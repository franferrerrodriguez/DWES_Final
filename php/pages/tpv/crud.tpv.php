<?php

require_once('../../utils/globalFunctions.php');
require_once('../../class/Category.class.php');
require_once('../../class/ArticleCategory.class.php');
require_once('../../class/Order.class.php');
require_once('../../class/OrderLine.class.php');

$action = $_POST["action"];

$id = null;
if(isset($_POST['id'])) {
    $id = $_POST["id"];
}

$result = [];
if($action === "categories") {
    $result = Category::getBySubcategoryId($id);
} else if($action === "categoryTitle") {
    $result = Category::getById($id);
} else if($action === "articles") {
    $result = ArticleCategory::getArticlesByCategoryId($id);
} else if($action === "currentOrder") {
    $result = Order::getMapCookieShoppingCart();
} else if($action === "addItem") {
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

    $result = $order;
} else if($action === "deleteItem") {
    $order = Order::getMapCookieShoppingCart();

    foreach ($order->getOrderLines() as $index => $orderLine) {
        if($orderLine->getArticleId() == $id) {
            $quantity = ($orderLine->getQuantity() - 1);
            if($quantity == 0) {
                $order->deleteOrderLineByArticleId($id);
            } else {
                $orderLine->setQuantity($quantity);
            }
        }
    }

    $order->updateOrderSessionCookiesIntoDB();

    // Actualizamos la Cookie
    setcookie("shopping_cart", json_encode_all($order), time() + 3600, "/");

    $result = $order;
}

echo json_encode_all($result);

?>