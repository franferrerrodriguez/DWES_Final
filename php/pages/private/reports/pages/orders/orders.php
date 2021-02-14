<script>
    $(document).ready(function() {
        $('#dataTable1').DataTable();
        $('#dataTable2').DataTable();

        let startDate = new Date();
        startDate.setMonth(startDate.getMonth() - 1);
        $('#startDate').val(formatDate(startDate));
        $('#endDate').val(formatDate(new Date()));
        refreshOrdersDateTable();
        refreshOrdersUserTable();

        $("#btnRefresh").click(function() {
            refreshOrdersDateTable();
            refreshOrdersUserTable();
        });

        function refreshOrdersDateTable() {
            $.ajax({
                type: "POST",
                url: "php/pages/private/reports/pages/orders/crud.orders.php",
                data: {
                    'action': 'ordersDateTable',
                    'startDate': $('#startDate').val(),
                    'endDate': $('#endDate').val()
                },
                success: function(data) {
                    data = JSON.parse(data);

                    let html = '';
                    let i = 1;
                    data.forEach(order => {
                        html += `
                        <tr>
                            <td>${ i }</td>
                            <td>${ order.id }</td>
                            <td>${ order.orderLines.length }</td>
                            <td>${ order.userId }</td>
                            <td>${ order.status }</td>
                            <td>${ order.date }</td>
                            <td>${ order.paidMethod }</td>
                        </tr>
                        `;
                        i++;
                    });
                    $('#ordersDateTable').html(html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }

        function refreshOrdersUserTable() {
            $.ajax({
                type: "POST",
                url: "php/pages/private/reports/pages/orders/crud.orders.php",
                data: {
                    'action': 'ordersUserTable',
                    'startDate': $('#startDate').val(),
                    'endDate': $('#endDate').val()
                },
                success: function(data) {
                    data = JSON.parse(data);

                    let html = '';
                    let i = 1;
                    data.forEach(user => {
                        html += `
                        <tr>
                            <td>${ i }</td>
                            <td>${ user.id }</td>
                            <td>${ user.firstName }</td>
                            <td>${ user.firstLastName } ${ user.secondLastName }</td>
                            <td>${ user.document }</td>
                            <td>${ user.email }</td>
                            <td class='center'>${ user.ordersProcessed }</td>
                            <td class='center'>${ user.ordersCancelled }</td>
                            <td class='center'>${ user.ordersReturned }</td>
                            <td class='center'>${ user.totalQuantity }</td>
                            <td class='right'>${ user.totalPrice }€</td>
                        </tr>
                        `;
                        i++;
                    });
                    $('#ordersUserTable').html(html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }
    });
</script>

<div class="form-row">
    <div class="form-group col-md-5">
        <label for="status">Fecha de inicio: </label>
        <input class="form-control" type="date" id="startDate">
    </div>
    <div class="form-group col-md-5">
        <label for="paidMethod">Fecha de fin: </label>
        <input class="form-control" type="date" id="endDate">
    </div>
    <div class="form-group col-md-2">
        <button type="button" class="btn btn-primary" id="btnRefresh" style="margin-top:33px;" title="Refrescar tabla">
            <i class="fas fa-sync-alt"></i>
            Refrescar
        </button>
    </div>
</div>

<hr/><h2>Pedidos entre fechas</h2><hr>

<table id="dataTable1" class="table-primary table-bordered" style="width:100%">
    <thead>
        <tr>
            <th class='center'>#</th>
            <th>Id Pedido</th>
            <th>Nº Líneas Pedido</th>
            <th>Id Cliente</th>
            <th class='center'>Estado</th>
            <th>Fecha de pedido</th>
            <th>Método de pago</th>
        </tr>
    </thead>
    <tbody id="ordersDateTable"></tbody>
</table>

<hr/>

<br><h2>Pedidos por usuario</h2><hr>

<table id="dataTable2" class="table-primary table-bordered" style="width:100%">
    <thead>
        <tr>
            <th class='center'>#</th>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Documento</th>
            <th>Email</th>
            <th class='center'>Total Pedidos realizados</th>
            <th class='center'>Total Pedidos cancelados</th>
            <th class='center'>Total Pedidos devueltos</th>
            <th class='center'>Total Artículos comprados</th>
            <th class='right'>Total Gastado</th>
        </tr>
    </thead>
    <tbody id="ordersUserTable"></tbody>
</table>