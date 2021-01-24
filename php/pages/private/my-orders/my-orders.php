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
                echo "<span class='badge badge-secondary'>" . $order['date'] . " - (" . $order['paid_method'] . ")</span><br>";
                echo "<span class='badge badge-" . Order::getStatusColor($order["status"]) . "'>PEDIDO " . Order::getStatusText($order["status"]) . "</span><br>";

                if($order["free_shipping"]) {
                    echo "<span class='badge badge-success'>Envío gatis</span>";
                }
                
                foreach ($order["orderLines"] as $index => $orderLine) {
                    echo "<h5 class='card-title'>";
                        echo "<img src='" . $orderLine->getArticleImgRoute() . "' width='100px'>";
                        echo $orderLine->getArticleName();
                    echo "</h5>";
                    echo "<p class='card-text' style='font-weight:normal;'>Cantidad: " . $orderLine->getQuantity() . "</p>";
                    echo "<p class='card-text' style='font-weight:normal;'>Total: " . $orderLine->getTotalPrice() . " €</p>";
                    echo "<a href='?page=article-detail/article-detail&id=" . $orderLine->getArticleId() . "' class='btn btn-primary'>Ver artículo</a><hr/>";
                }

                if($order['status'] == 1) {
                    echo "<a href='#' onclick='cancelOrder(" . $order['id'] . ");' class='btn btn-danger'>Cancelar pedido</a>";
                    echo "&nbsp<a href='#' onclick='returnOrder(" . $order['id'] . ");' class='btn btn-warning'>Devolver pedido</a>";
                } else if($order['status'] == 2) {
                    echo "<a href='#' onclick='reorderOrder(" . $order['id'] . ");' class='btn btn-success'>Reanudar pedido</a>";
                } else if($order['status'] == 3) {
                    echo "<a href='#' onclick='reorderOrder(" . $order['id'] . ");' class='btn btn-success'>Cancelar devolución</a>";
                }

                echo "&nbsp<a href='?page=contact' class='btn btn-info'>Problema con pedido</a>";
            echo "</div>";
        echo "</div><br>";
    }
}
?>

<script type="text/javascript">
    function cancelOrder(id) {
        if (window.confirm(`¿Está seguro que desea cancelar el pedido ${ id }?`)) {
            $.ajax({
                type: "POST",
                url: "php/pages/private/my-orders/crud.my-orders.php",
                data: { action: 'cancel', id: id },
                success: function(data) {
                    if(data === 'OK') {
                        location.reload();
                    } else {
                        $('#modaladdEdit').modal('toggle');
                        showAlert(data, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#modaladdEdit').modal('toggle');
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }
    }

    function returnOrder(id) {
        if (window.confirm(`¿Está seguro que desea devolver el pedido ${ id }?`)) {
            $.ajax({
                type: "POST",
                url: "php/pages/private/my-orders/crud.my-orders.php",
                data: { action: 'return', id: id },
                success: function(data) {
                    if(data === 'OK') {
                        location.reload();
                    } else {
                        $('#modaladdEdit').modal('toggle');
                        showAlert(data, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#modaladdEdit').modal('toggle');
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }
    }

    function reorderOrder(id) {
        if (window.confirm(`¿Está seguro que desea volver a tramitar el pedido ${ id }?`)) {
            $.ajax({
                type: "POST",
                url: "php/pages/private/my-orders/crud.my-orders.php",
                data: { action: 'reorder', id: id },
                success: function(data) {
                    if(data === 'OK') {
                        location.reload();
                    } else {
                        $('#modaladdEdit').modal('toggle');
                        showAlert(data, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#modaladdEdit').modal('toggle');
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }
    }
</script>