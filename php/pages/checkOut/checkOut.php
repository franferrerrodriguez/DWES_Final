<?php
require_once("php/class/User.class.php");
$user = User::getUserSession();
?>

<h2>Tramitar pedido</h2><hr/>

<form id="form">
    <input type="hidden" id="id" value="<?php echo $user->getId(); ?>">
    <h5>DATOS DEL COMPRADOR:</h5>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->getEmail(); ?>" readonly>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="firstname">Nombre</label>
            <input type="text" class="form-control" id="firstname" placeholder="Nombre" value="<?php echo $user->getFirstName(); ?>" readonly>
        </div>
        <div class="form-group col-md-4">
            <label for="first_lastname">Primer apellido</label>
            <input type="text" class="form-control" id="first_lastname" placeholder="Primer apellido" value="<?php echo $user->getFirstLastName(); ?>" readonly>
        </div>
        <div class="form-group col-md-4">
            <label for="second_lastname">Segundo apellido</label>
            <input type="text" class="form-control" id="second_lastname" placeholder="Segundo apellido" value="<?php echo $user->getSecondLastName(); ?>" readonly>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="document">Documento</label>
            <input type="text" class="form-control" id="document" placeholder="Documento" value="<?php echo $user->getDocument(); ?>" readonly>
        </div>
        <div class="form-group col-md-4">
            <label for="phone1">Teléfono 1</label>
            <input type="number" class="form-control" id="phone1" placeholder="Teléfono 1" value="<?php echo $user->getPhone1(); ?>" readonly>
        </div>
        <div class="form-group col-md-4">
            <label for="phone2">Teléfono 2</label>
            <input type="number" class="form-control" id="phone2" placeholder="Teléfono 2" value="<?php echo $user->getPhone2(); ?>" readonly>
        </div>
    </div>
    <br><h5>DIRECCIÓN DE ENVÍO:</h5>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="address">Dirección</label>
            <input type="text" class="form-control" id="address" placeholder="Dirección" value="<?php echo $user->getAddress(); ?>" readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="location">Población</label>
            <input type="text" class="form-control" id="location" placeholder="Población" value="<?php echo $user->getLocation(); ?>" readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="province">Provincia</label>
            <input type="text" class="form-control" id="province" placeholder="Provincia" value="<?php echo $user->getProvince(); ?>" readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="country">País</label>
            <input type="text" class="form-control" id="country" placeholder="País" value="<?php echo $user->getCountry(); ?>" readonly>
        </div>
    </div>
    <br><h5>PEDIDO Y PAGO:</h5>
    <table class="table table-active table-sm">
        <thead>
            <tr>
                <th></th>
                <th>Artículo</th>
                <th>Precio</th>
                <th>Unidades</th>
                <th>Total</th>
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
                        echo "<td class='align-middle'>" . $orderLine->getQuantity() . "</td>";
                        echo "<td class='align-middle'>" . $orderLine->getTotalPrice() . "€</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <h5 style="text-align:right;">Total pedido: <span id="totalPrice"><?php echo $order ? $order->getTotalPrice() : 0 ?></span>€</h5>
    <hr/>
    <br><h5>FORMA DE PAGO:</h5>
    <select id="paidMethod" class="form-control" required>
        <option value="" selected>Selecciona forma de pago</option>
        <option value="TRANSFERENCIA BANCARIA">TRANSFERENCIA BANCARIA</option>
        <option value="CONTRAREEMBOLSO">CONTRAREEMBOLSO</option>
        <option value="TARJETA DE CRÉDITO">TARJETA DE CRÉDITO</option>
        <option value="PAYPAL">PAYPAL</option>
        <option value="GOOGLE PAY">GOOGLE PAY</option>
        <option value="APPLE PAY">APPLE PAY</option>
    </select>
    <br>
    <i class="fas fa-credit-card fa-3x"></i>
    <i class="fab fa-cc-paypal fa-3x"></i>
    <i class="fab fa-google-pay fa-3x"></i>
    <i class="fab fa-cc-apple-pay fa-3x"></i>
    <br><br>

    <div id="modalAlert"></div>

    <button type="submit" id="button<?php echo $id; ?>" class="btn btn-success">Finalizar pedido</button>
</form>

<script type="text/javascript">
    // Si el carrito está vacío regresamos al inicio
    if(isShoppingCartEmpty()) {
        location.href ="?page=index";
    }
    $(document).ready(function() {
        $('#form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "php/pages/checkOut/crud.checkOut.php",
                data: { 
                    paidMethod: $('#paidMethod').val()
                },
                success: function(data) {
                    console.log(data);
                    if(data === 'OK') {
                        location.href = '?page=private/my-orders/my-orders';
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
        });
    });
</script>