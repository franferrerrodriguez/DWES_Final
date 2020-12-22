<?php

?>

<div class="container">
    <div class="row">
        <div class="col-8">
        <h2>Carrito</h2>
        <h4>(2) artículos seleccionados</h4>
        <table class="table table-active table-sm">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Precio</th>
                        <th>Unidades</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody style="background-color:#fff;">
                    <tr>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
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
            RIGHT
        </div>
    </div>
</div>