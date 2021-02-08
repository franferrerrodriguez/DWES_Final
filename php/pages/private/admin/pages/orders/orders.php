<?php
require_once("php/class/User.class.php");
require_once("php/class/Order.class.php");
$orders = Order::getAll();
?>

<script type="text/javascript">
    let orders = [];
    $(document).ready(function() {
        $('#dataTable').DataTable();

        $('#formaddEdit').on('submit', function(e) {
            let formValid = true;
            e.preventDefault();
            let order = getOrder();

            if(formValid) {
                $.ajax({
                    type: "POST",
                    url: "php/pages/private/admin/pages/orders/crud.orders.php?action=addEdit",
                    data: order,
                    success: function(data) {
                        if(data === 'OK') {
                            location.reload();
                        } else {
                            resetFields();
                            $('#modaladdEdit').modal('toggle');
                            showAlert(data, "danger");
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        resetFields();
                        $('#modaladdEdit').modal('toggle');
                        showAlert("Ha ocurrido un error inesperado.", "danger");
                    }
                });
            }
        });
    });

    function openModal(action, input) {
        let order = null;
        resetFields();
        if(input.value) {
            let value = JSON.parse(input.value);
            order = {
                id: value['id'],
                userId: value['userId'],
                status: value['status'],
                statusText: value['statusText'],
                orderLines: value['orderLines'],
                totalQuantity: value['totalQuantity'],
                totalPrice: value['totalPrice'],
                freeShipping: value['freeShipping'],
                date: value['date'],
                paidMethod: value['paidMethod']
            };
        }

        if(action == 'edit') {
            $('#modaladdEdit').modal('show');
            $('#modalTitleaddEdit').html('Editar pedido');
            $('#email').attr('readonly', true);
        }

        fillFields(order);
    }

    function getOrder() {
        return {
            id: $('#id').val(),
            userId: $('#userId').val(),
            status: $('#status').val(),
            statusText: $('#statusText').val(),
            orderLines: $('#orderLines').val(),
            totalQuantity: $('#totalQuantity').val(),
            totalPrice: $('#totalPrice').val(),
            freeShipping: $('#freeShipping').val(),
            date: $('#date').val(),
            paidMethod: $('#paidMethod').val()
        }
    }

    function resetFields() {
        $('#document').val('');
        $('#password1').val('');
        $('#password2').val('');
        $('#modalAlert').html('');
    }

    function fillFields(order) {
        $('#id').val(order && order.id ? order.id : '');
        $('#userId').val(order && order.userId ? order.userId : '');
        $('#status').val(order && order.status ? order.status : '');
        $('#statusText').val(order && order.statusText ? order.statusText : '');
        $('#totalQuantity').val(order && order.totalQuantity ? order.totalQuantity : '');
        $('#totalPrice').val(order && order.totalPrice ? order.totalPrice : '');
        $('#freeShipping').val(order && order.freeShipping ? order.freeShipping : '');
        $('#date').val(order && order.date ? order.date : '');
        $('#paidMethod').val(order && order.paidMethod ? order.paidMethod : '');
        fillOrderLines(order && order.orderLines ? order.orderLines : '');
    }

    function fillOrderLines(orderLines) {
        $('#orderLines').html('');
        if(orderLines) {
            let i = 1;
            orderLines.forEach(orderLine => {
                $('#orderLines').append(`
                    <tr>
                        <td>${ i }</td>
                        <td>${ orderLine.articleId }</td>
                        <td>${ orderLine.articleName }</td>
                        <td class='center'>${ orderLine.quantity }</td>
                        <td class='right'>${ orderLine.price }€</td>
                        <td class='right'>${ orderLine.totalPrice }€</td>
                    </tr>
                `);
                i++;
            });
        }
    }
</script>

<!-- Tabla listado de pedidos -->
<br><h2>Listado de pedidos</h2><hr>
<table id="dataTable" class="table-primary table-bordered" style="width:100%">
    <thead>
        <tr>
            <th class='center'>#</th>
            <th>Id Pedido</th>
            <th>Id Cliente</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th class='center'>Estado</th>
            <th class='center'>Envío gratis</th>
            <th>Fecha de pedido</th>
            <th>Método de pago</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($orders) {
                foreach ($orders as $i => $order) {
                    $user = User::getById($order->getUserId());
                    $order->statusText = Order::getStatusText($order->getStatus());
                    echo "<tr>";
                        echo "<td class='center'>" . ($i + 1) . "</td>";
                        echo "<td>" . $order->getId() . "</td>";
                        echo "<td>" . $user->getId() . "</td>";
                        echo "<td>" . $user->getFirstName() . "</td>";
                        echo "<td>" . $user->getFirstLastName() . " " . $user->getSecondLastName() . "</td>";
                        echo "<td class='center'><span class='badge badge-" . Order::getStatusColor($order->getStatus()) . "'>" . $order->statusText . "</span></td>";
                        if($order->getFreeShipping() === '1') {
                            echo "<td class='center'><span class='badge badge-success'>SÍ</span></td>";
                        } else {
                            echo "<td class='center'><span class='badge badge-danger'>NO</span></td>";
                        }
                        echo "<td>" . $order->getDate() . "</td>";
                        echo "<td>" . $order->getPaidMethod() . "</td>";
                        echo "<td class='center'>
                            <button type='button' class='btn btn-success btn-sm' value='" . json_encode_all($order) . "' onclick='openModal(\"edit\", this)'>
                                <i class='fas fa-edit'></i>
                            </button>
                        </td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>

<!-- Ventana Modal para añadir/editar usuarios -->
<?php include('modal/addEditUser.php'); ?>

<!-- Ventana Modal para eliminar usuarios -->
<?php include('modal/deleteUser.php'); ?>