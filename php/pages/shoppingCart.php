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
                                echo "<td class='align-middle'><input type='number' id='quantity" . $orderLine->getArticleId() . "' onkeyup='updateQuantity(" . $orderLine->getArticleId() . ");' onchange='updateQuantity(" . $orderLine->getArticleId() . ");' style='width:30px;' value='" . $orderLine->getQuantity() . "'></td>";
                                echo "<td class='align-middle'><span id='lineTotalPrice" . $orderLine->getArticleId() . "'>" . $orderLine->getTotalPrice() . "</span>€</td>";
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
            <a class="btn btn-secondary <?php if(count($order->getOrderLines()) === 0) { echo 'disabled'; } ?>" href="php/utils/shoppingCart.php?action=deleteItems" role="button">Vaciar carrito</a>
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
                    <li class="list-group-item" style="font-weight:bold; text-align:center;background-color:#E8E8E8;">
                        TICKET
                    </li>
                    <?php
                        if($order && $order->getFreeShipping()) {
                            echo "<li class='list-group-item' style='height:54px;'>";
                                echo "<h5><span class='badge badge-success'>Envío gratis</span></h5>";
                            echo "</li>";
                        }
                    ?>
                    <li class="list-group-item" style="height:62px;">
                        <h3>Total: <span id="totalPrice"><?php echo $order ? $order->getTotalPrice() : 0 ?></span>€</h3>
                    </li>
                </ul>
                <div class="card-body">
                    <?php
                        if(isLogged()) {
                            $disabled = count($order->getOrderLines()) === 0 ? "disabled" : "";
                            echo "<a class='btn btn-success $disabled' href='?page=checkout' role='button' style='width: 100%;'>Realizar pedido</a>";
                        } else {
                            echo "<a class='btn btn-success' href='?page=register' role='button' style='width: 100%;'>Registrarse</a>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateQuantity(articleId) {
        if(articleId) {
            let quantity = $('#quantity' + articleId).val();
            if(!quantity || quantity > 30) {
                $('#quantity' + articleId).val(1);
                quantity = 1;
            }
            $.ajax({
                type: "POST",
                url: "php/utils/shoppingCart.php?action=updateQuantity",
                data: { 'articleId': articleId, 'quantity': quantity },
                success: function(data) {
                    try {
                        data = JSON.parse(data);
                        data.orderLines.forEach(function(e, i) {
                            $('#lineTotalPrice' + e.articleId).html(e.totalPrice);
                        });
                        $('#shoppingCartQuantity').html(data.totalQuantity);
                        $('#totalPrice').html(data.totalPrice);
                    } catch (e) {
                        $('#modaladdEdit').modal('toggle');
                        showAlert(e, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }
    }

    function deleteOrderLine(articleId) {
        if (window.confirm("¿Está seguro que desea eliminar la línea de pedido?")) {
            $.ajax({
                type: "POST",
                url: "php/utils/shoppingCart.php?action=deleteItem",
                data: { 'articleId': articleId },
                success: function(data) {
                    if(data === 'OK') {
                        location.reload();
                    } else {
                        $('#modaladdEdit').modal('toggle');
                        showAlert(data, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }
    }
</script>