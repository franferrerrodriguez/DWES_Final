<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

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

                    let html = '';
                    let i = 1;
                    data.forEach(article => {
                        console.log(article);
                        html += `
                        <tr>
                            <td>${ i }</td>
                            <td>${ article.id }</td>
                            <td>${ article.img_route }</td>
                            <td>${ article.brand }</td>
                            <td>${ article.name }</td>
                            <td>${ article.is_active }</td>
                            <td>${ article.total }</td>
                        </tr>
                        `;
                        i++;
                    });
                    $('#articlesTable').html(html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }
    });
</script>

<br><h2>Artículos más vendidos</h2><hr>

<table id="dataTable" class="table-primary table-bordered" style="width:100%">
    <thead>
        <tr>
            <th class='center'>#</th>
            <th>Id</th>
            <th>Imagen</th>
            <th>Marca</th>
            <th>Nombre</th>
            <th class='center'>Estado</th>
            <th class='center'>Total Ventas</th>
        </tr>
    </thead>
    <tbody id="articlesTable"></tbody>
</table>