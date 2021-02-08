<?php $id = "addEdit"; ?>

<?php include('php/pages/common/open-modal-large.php'); ?>

<form id="form<?php echo $id; ?>" class="was-validated">
    <input type="hidden" id="statusText" value="">
    <input type="hidden" id="totalPrice" value="">
    <input type="hidden" id="totalQuantity" value="">
    <input type="hidden" id="userId" value="">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="date">Id Pedido</label>
            <input type="text" class="form-control" id="id" placeholder="Id Pedido" readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="date">Fecha de pedido</label>
            <input type="text" class="form-control" id="date" placeholder="Fecha de pedido" readonly>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="status">Estado</label>
            <select id="status" class="form-control">
            <?php
            foreach (Order::getStatusArray() as $i => $status) {
                echo "<option value='" . $status . "'selected>" . Order::getStatusText($status) . "</option>";
            }
            ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="paidMethod">Método de pago</label>
            <select id="paidMethod" class="form-control" required>
                <option value="TRANSFERENCIA BANCARIA">TRANSFERENCIA BANCARIA</option>
                <option value="CONTRAREEMBOLSO">CONTRAREEMBOLSO</option>
                <option value="TARJETA DE CRÉDITO">TARJETA DE CRÉDITO</option>
                <option value="PAYPAL">PAYPAL</option>
                <option value="GOOGLE PAY">GOOGLE PAY</option>
                <option value="APPLE PAY">APPLE PAY</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="freeShipping">Envío gratis</label>
            <select id="freeShipping" class="form-control">
                <option value="0">NO</option>
                <option value="1">SÍ</option>
            </select>
        </div>
        <div class="form-group col-md-6">

        </div>
    </div>
    <table class="table-primary table-bordered" style="width:100%">
        <thead>
            <tr>
                <th class='center'>#</th>
                <th>Id Artículo</th>
                <th>Nombre Artículo</th>
                <th class='center'>Cantidad</th>
                <th class='right'>Precio</th>
                <th class='right'>Total</th>
            </tr>
        </thead>
        <tbody id="orderLines" style="background-color:#fff"></tbody>
    </table>
    <br>
    <div id="modalAlert"></div>

    <button type="submit" id="button<?php echo $id; ?>" class="btn btn-primary">Aceptar</button>
</form>

<?php include('php/pages/common/close-modal-large.php'); ?>