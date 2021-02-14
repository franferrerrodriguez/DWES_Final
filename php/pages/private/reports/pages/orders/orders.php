<script>
    $(document).ready(function() {
        let table1 = $('#dataTable1').DataTable({
            columns: [
                {data: "index", title: '#'},
                {data: "id", title: 'Id Pedido'},
                {data: "orderLines.length", title: 'Nº Líneas Pedido'},
                {data: "userId", title: 'Id Cliente'},
                {data: "status", title: 'Estado'},
                {data: "date", title: 'Fecha de pedido'},
                {data: "paidMethod", title: 'Método de pago'}
            ]
        });

        let table2 = $('#dataTable2').DataTable({
            columns: [
                {data: "index", title: '#'},
                {data: "id", title: 'Id'},
                {data: "firstName", title: 'Nombre'},
                {data: "firstLastName", title: 'Apellidos'},
                {data: "document", title: 'Documento'},
                {data: "email", title: 'Email'},
                {data: "ordersProcessed", title: 'Total Pedidos realizados'},
                {data: "ordersCancelled", title: 'Total Pedidos cancelados'},
                {data: "ordersReturned", title: 'Total Pedidos devueltos'},
                {data: "totalQuantity", title: 'Total Artículos comprados'},
                {data: "totalPrice", title: 'Total Gastado'}
            ]
        });

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

                    let i = 1;
                    data.forEach(item => {
                        item.index = i;
                        i++;
                    });
                    table1.rows().remove();
                    table1.rows.add(data).draw();
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

                    let i = 1;
                    data.forEach(item => {
                        item.index = i;
                        i++;
                    });
                    table2.rows().remove();
                    table2.rows.add(data).draw();
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

<table id="dataTable1" class="table-primary table-bordered" style="width:100%"></table>

<hr/>

<br><h2>Pedidos por usuario</h2><hr>

<table id="dataTable2" class="table-primary table-bordered" style="width:100%"></table>