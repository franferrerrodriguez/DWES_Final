<script>
    let colors = ['E8E8E8', 'C4B9E7', 'E3CC96', 'F3D0D0', 'E4B9E7', 'DEFCC1', 
                  'E7B9B9', 'E39696', 'D1E7B9', 'F3DBD0', 'B9E4E7', '96E3A8', 
                  'F3ECD0', 'B9C5E7', 'F3ECD0', 'B9D6E7', '96DBE3', 'C2E7B9', 
                  'D2B9E7', 'E7B9CC', '96B3E3', '9A96E3'];
    let returnCategory = [];

    $(document).ready(function() {
        getCategories();
    });

    function getCategories(categoryId = null, back = false) {
        if(!back)
            returnCategory.push(categoryId);
        $.ajax({
            type: "GET",
            url: "php/pages/tpv/crud.tpv.php",
            data: { action: 'categories', id: categoryId },
            success: function(data) {
                data = JSON.parse(data);
                loadCategoryTitle(categoryId);
                loadCategories(data);
                getArticles(categoryId);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });
    }
    
    function loadCategoryTitle(categoryId ) {
        if(categoryId) {
            $.ajax({
            type: "GET",
            url: "php/pages/tpv/crud.tpv.php",
            data: { action: 'categoryTitle', id: categoryId },
            success: function(data) {
                data = JSON.parse(data);
                $('#titleCategory').html(data.name);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });
        } else {
            $('#titleCategory').html('Todas');
        }
    }

    function loadCategories(data) {
        let items_row = 3;
        let html = '';
        let r = 0;
        let i = 0;
        let color = 0;
        data.unshift(null);
        data.forEach(item => {
            if(r === 0) html += `<div class='row' style='cursor:pointer;'>`;
            if(i === 0) {
                html += `
                    <div class='col-sm tpv-category' style='line-height:155px;' onclick='btnBackCategories()'>
                        <i class='fas fa-undo-alt fa-4x'></i>
                    </div>
                `;
            } else {
                html += `
                    <div class='col-sm tpv-category' onclick='getCategories(${ item.id })' style='background-color:#${ colors[color] };'>
                        ${ item.name }
                    </div>
                `;
            }
            if(i === data.length - 1) {
                for(a = 0; a < items_row - (r + 1); a++) {
                    html += `
                        <div class='col-sm tpv-category' style='background-color:transparent; border:none;cursor:default;'></div>
                    `;
                }
            }
            if(r === items_row - 1) {
                html += `</div>`;
                r = 0;
            } else {
                r++;
            }
            if(color === colors.length) {
                color = 0;
            } else {
                color++;
            }
            i++;
        });

        $('#contentCategory').html(html);
    }

    function btnBackCategories() {
        returnCategory.pop();
        getCategories(returnCategory[returnCategory.length - 1], true);
    }

    function getArticles(categoryId) {
        $('#contentArticles').html("Cargando artículos...");
        $.ajax({
            type: "GET",
            url: "php/pages/tpv/crud.tpv.php",
            data: { action: 'articles', id: categoryId },
            success: function(data) {
                data = JSON.parse(data);
                loadArticles(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });
    }

    function loadArticles(data) {
        let items_row = 5;
        let html = '';
        let r = 0;
        let i = 0;

        if(data.length > 0) {
            data.forEach(item => {
                if(r === 0) html += `<div class='row' style='cursor:pointer;'>`;
                let name = item.name.substr(0, 20);
                if(name.length >= 20 ) 
                    name += '...';
                html += `
                    <div class='col-sm tpv-category' onclick='addArticle(${ item.id })'>
                        <img src='${ item.imgRoute }' style='width:60px;height:60px;'>
                        ${ name }
                    </div>
                `;
                if(i === data.length - 1) {
                    for(a = 0; a < items_row - (r + 1); a++) {
                        html += `
                            <div class='col-sm tpv-category' style='background-color:transparent; border:none;cursor:default;'></div>
                        `;
                    }
                }
                if(r === items_row - 1) {
                    html += `</div>`;
                    r = 0;
                } else {
                    r++;
                }
                i++;
            });
        } else {
            html = "Elije una categoría para filtrar artículos.";
        }

        $('#contentArticles').html(html);
    }

    function addArticle(articleId) {
        $.ajax({
            type: "GET",
            url: "php/pages/tpv/crud.tpv.php",
            data: { action: 'addItem', id: articleId },
            success: function(data) {
                data = JSON.parse(data);
                updateTopMenu(data);
                updateTable(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });

        function updateTopMenu(order) {
            // Top Order Lines
            let htmlOrderLines = '';
            order.orderLines.forEach(orderLine => {
                htmlOrderLines += `<a class='dropdown-item' href='#'><span id='shoppingCartLine${ orderLine.articleId }'>${ orderLine.articleName.substr(0, 25) } (${ orderLine.quantity }) ${ orderLine.price }€</span></a>`;
            });
            $('#shoppingCartOrderLines').html(htmlOrderLines);

            // Top Total
            $('#shoppingCartTotalQuantity').css('color', 'red');
            $('#shoppingCartTotalQuantity').html(`(${ order.totalQuantity }) ${ order.totalPrice }€`);
            $('#shoppingCartTotalPrice').html(`Total (${ order.totalQuantity }): ${ order.totalPrice }€`);
        }

        function updateTable(order) {
            $('#blackTotalPrice').html(order.totalPrice);
            console.log(order);












        }
    }
</script>

<div class="row">
    <div class="col-sm-6">
        <div class="tableFixHead" style="height:500px">
            <table class="table-primary table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="background-color:#b8daff;" class='center'>#</th>
                        <th style="background-color:#b8daff;">Id Artículo</th>
                        <th style="background-color:#b8daff;">Nombre Artículo</th>
                        <th style="background-color:#b8daff;" class='center'>Cantidad</th>
                        <th style="background-color:#b8daff;" class='right'>Precio</th>
                        <th style="background-color:#b8daff;" class='right'>Total</th>
                    </tr>
                </thead>
                <tbody id="orderLines" style="background-color:#fff">
                    <?php
                    for($i = 0; $i < 120; $i++) {
                        echo "<tr>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="tpv-text">
            Total: <span id="blackTotalPrice">0.00</span>€&nbsp
        </div>
        <br>
        <h4>Categoria: <span id="titleCategory"></span></h4>
        <div id="contentCategory" class="scrollDiv" style="height:340px;border:solid 1px #000;"></div>
    </div>
</div>

<hr/>

<h4>Artículos</h4>
<div id="contentArticles" class="scrollDiv" style="height:300px;border:solid 1px #000;"></div>

<hr/>

<div class="row">
    <div class="col-sm">
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
    </div>
</div>