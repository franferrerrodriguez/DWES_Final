<script>
    $(document).ready(function() {
        let table = $('#dataTable').DataTable({
            columns: [
                {data: "index", title: '#'},
                {data: "id", title: 'Id'},
                {data: "brand", title: 'Marca'},
                {data: "name", title: 'Nombre'},
                {data: "is_active", title: 'Estado'},
                {data: "total", title: 'Total Ventas'}
            ]
        });

        let startDate = new Date();
        startDate.setMonth(startDate.getMonth() - 1);
        $('#startDate').val(formatDate(startDate));
        $('#endDate').val(formatDate(new Date()));
        refreshArticlesTable();

        $("#btnRefresh").click(function() {
            refreshArticlesTable();
        });

        function refreshArticlesTable() {
            $.ajax({
                type: "POST",
                url: "php/pages/private/reports/pages/articles/crud.articles.php",
                data: {
                    'action': 'articlesTable'
                },
                success: function(data) {
                    data = JSON.parse(data);

                    let i = 1;
                    data.forEach(item => {
                        item.index = i;
                        i++;
                    });

                    table.rows().remove();
                    table.rows.add(data).draw();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }
    });
</script>

<br><h2>Artículos más vendidos</h2><hr>

<table id="dataTable" class="table-primary table-bordered" style="width:100%"></table>