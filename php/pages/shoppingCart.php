<?php
    require_once("php/class/Order.class.php");
    $order = Order::getMapCookieShoppingCart();
?>

<div class="container">
    <div class="row">
        <div class="col-8">
        <h2>Carrito</h2>
        <hr/>
        <h4>(<?php echo $order ? count($order->getOrderLines()) : 0 ?>) artículos seleccionados</h4>
        <table class="table table-active table-sm">
                <thead>
                    <tr>
                        <th></th>
                        <th>Artículo</th>
                        <th>Precio</th>
                        <th>Unidades</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody style="background-color:#fff;">
                    <?php
                    if($order) {
                        foreach ($order->getOrderLines() as $index => $orderLine) {
                            echo "<tr>";
                                echo "<td class='center'><img style='height:70px;' src='" . $orderLine->getArticleImgRoute() . "' alt='" . $orderLine->getArticleImgRoute() . "'></td>";
                                echo "<td class='align-middle'>" . $orderLine->getArticleName() . "</td>";
                                echo "<td class='align-middle'>" . $orderLine->getPrice() . "€</td>";
                                echo "<td class='align-middle'><input type='number' onblur='updateQuantity(" . $orderLine->getArticleId() . ");' style='width:30px;' value='" . $orderLine->getQuantity() . "'></td>";
                                echo "<td class='align-middle'>" . $orderLine->getTotalPrice() . "€</td>";
                                echo "<td class='align-middle'>
                                    <button type='button' onclick='deleteOrderLine(" . $orderLine->getArticleId() . ");' class='btn btn-danger btn-sm'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                                </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <hr/>
            <a class="btn btn-secondary" href="php/utils/shoppingCart.php?action=deleteItems" role="button">Vaciar carrito</a>
            <a class="btn btn-primary" href="?page=index" role="button" style="float:right;">Seguir comprando</a>
            <hr/>
            <i class="fas fa-shield-alt fa-2x"></i>&nbspPago 100% seguro
            <br><br>
            Métodos de pago:<br>
            <i class="fas fa-credit-card fa-3x"></i>
            <i class="fab fa-cc-paypal fa-3x"></i>
            <i class="fab fa-google-pay fa-3x"></i>
            <i class="fab fa-cc-apple-pay fa-3x"></i>
        </div>
        <div class="col-4">
            <div class="card" style="width: 18rem;">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" style="font-weight:bold; text-align:center;">
                        TICKET
                    </li>
                    <?php
                        if($order && $order->getFreeShipping()) {
                            echo "<li class='list-group-item' style='height:54px;'>";
                                echo "<h5><span class='badge badge-success'>Envío gatis</span></h5>";
                            echo "</li>";
                        }
                    ?>
                    <li class="list-group-item" style="height:62px;">
                        <h3>Total: <?php echo $order ? $order->getTotalPrice() : 0 ?>€</h3>
                    </li>
                </ul>
                <div class="card-body">
                    <a class="btn btn-success" href="#" role="button" style="width: 100%;">Realizar pedido</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateQuantity(orderLine) {
        $.ajax({
            type: "POST",
            url: "php/utils/shoppingCart.php?action=updateQuantity",
            data: $("#form").serialize(),
            success: function(data) {
                console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });
    }

    function deleteOrderLine(orderLine) {
        $.ajax({
            type: "POST",
            url: "php/utils/shoppingCart.php?action=deleteItem",
            data: $("#form").serialize(),
            success: function(data) {
                console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });
    }
</script>