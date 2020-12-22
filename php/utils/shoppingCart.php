<?php

require_once("../class/Article.class.php");

$action = $_REQUEST['action'];

if(session_id() == '') {
    session_start();
}

if($action === "addItem") {
    $id = $_REQUEST['id'];
    $article = Article::getById($id);
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

    $articles = [];
    if(isset($_SESSION['shopping_cart']) && isset($_SESSION['shopping_cart']['articles'])) {
        $articles = $_SESSION['shopping_cart']['articles'];
    }
    
    array_push($articles, array(
        "id" => $id,
        "name" => $article->getName(),
        "quantity" => $quantity,
        "price" => $price,
        "total_price" => $price * $quantity
    ));

    $total_price = 0;
    foreach ($articles as $index => $article) {
        $total_price += $article['total_price'];
    }
    
    $_SESSION["shopping_cart"] = array(
        "articles" => $articles,
        "total_quantity" => count($articles),
        "total_price" => $total_price
    );
    
    header('Location: /?page=shoppingCart');
} else if($action === "deleteItems") {
    unset($_SESSION['shopping_cart']);
    header('Location: /?page=index');
}

?>