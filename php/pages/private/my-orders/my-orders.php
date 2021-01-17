<?php
require_once("php/class/Order.class.php");
$orders = Order::getFinishedByUserId();
?>

<h2>Mis pedidos</h2><hr/>

<?php
if(is_null($orders) || count($orders) === 0) {
    echo "Todavía no se han realizado pedidos.<hr/>";
    echo "<a class='btn btn-primary' href='?page=index' role='button'>Seguir comprando</a>";
} else {
    foreach ($orders as $index => $order) {
        echo "<div class='card'>";
            echo "<h5 class='card-header'>Pedido: " . $order['id'] . " - Cantidad: " . $order["total_quantity"] . " - Total: " . $order["total_price"] . " €</h5>";
            echo "<div class='card-body'>";
                echo "<p class='card-text'>" . $order["status"] . "</p>";
                if($order["free_shipping"]) {
                    echo "<span class='badge badge-success'>Envío gatis</span>";
                }
                foreach ($order["orderLines"] as $index => $orderLine) {
                    echo "<h5 class='card-title'>";
                        echo "<img src='" . $orderLine->getArticleImgRoute() . "' width='100px'>";
                        echo $orderLine->getArticleName();
                    echo "</h5>";
                    echo "<p class='card-text'>" . $orderLine->getTotalPrice() . " €</p>";
                    echo "<a href='?page=article-detail&id=" . $orderLine->getArticleId() . "' class='btn btn-primary'>Ver artículo</a>";
                }
                echo "<hr><a href='?page=contact' class='btn btn-warning'>Problema con pedido</a>";
            echo "</div>";
        echo "</div><br>";
    }
}
?>