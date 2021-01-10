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
            echo "<h5 class='card-header'>Pedido nº: " . $order['id'] . "</h5>";
            echo "<div class='card-body'>";
                echo "<h5 class='card-title'>Special title treatment</h5>";
                echo "<p class='card-text'>With supporting text below as a natural lead-in to additional content.</p>";
                echo "<a href='#' class='btn btn-primary'>Go somewhere</a>";
            echo "</div>";
        echo "</div><br>";
    }
}
?>