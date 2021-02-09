<script>
    let colors = ['E8E8E8', 'C4B9E7', 'E3CC96', 'F3D0D0', 'E4B9E7', 'DEFCC1', 
                  'E7B9B9', 'E39696', 'D1E7B9', 'F3DBD0', 'B9E4E7', '96E3A8', 
                  'F3ECD0', 'B9C5E7', 'F3ECD0', 'B9D6E7', '96DBE3', 'C2E7B9', 
                  'D2B9E7', 'E7B9CC', '96B3E3', '9A96E3'];
    let returnCategory = [];

    $(document).ready(function() {
        getCategories();
        updateOrder();
    });

    function getCategories(categoryId = null, back = false) {
        if(categoryId && !back)
            returnCategory.push(categoryId);
        $.ajax({
            type: "POST",
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
            type: "POST",
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

        if((data.length > 0 && data[0].parentCategoryId) || returnCategory.length > 0) {
            data.unshift(null);
        }
        
        data.forEach(item => {
            if(r === 0) html += `<div class='row' style='cursor:pointer;'>`;
            if(!data[i]) {
                html += `
                    <div class='col-sm tpv-category' style='line-height:155px;' onclick='btnBackCategories()'>
                        <i class='fas fa-undo-alt fa-4x'></i>
                    </div>
                `;
            } else {
                let name = item.name.substr(0, 30);
                if(name.length >= 30) 
                    name += '...';
                html += `
                    <div class='col-sm tpv-category' onclick='getCategories(${ item.id })' style='background-color:#${ colors[color] };'>
                        ${ name }
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
            type: "POST",
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
                let name = item.name.substr(0, 30);
                if(name.length >= 30) 
                    name += '...';

                let htmlPrice = '';
                if(item.priceDiscount > 0) {
                    htmlPrice = `
                        <span class='card-article-price-promotion-in'>${ item.priceDiscount }€</span>
                        <span class='card-article-price-promotion-out'>${ item.price }€</span>
                    `;
                } else if(item.percentageDiscount > 0) {
                    let price_discount = (item.price - ((item.price * item.percentageDiscount / 100))).toFixed(2);
                    htmlPrice = `
                        <span class='card-article-price-promotion-in'>${ price_discount }€</span>
                        <span class='card-article-price-promotion-out'>${ item.price }€</span>
                    `;
                } else {
                    htmlPrice = `
                        <span class='card-article-price'>${ item.price }€</span>
                    `;
                }

                let background = '';
                if(item.stock <= 0)
                    background = 'background-color:#FF5651';

                html += `
                    <div class='col-sm tpv-article' style='${ background }' onclick='addArticle(${ item.id }, ${ item.stock })' title='Stock: ${ item.stock }'>
                        <div style='margin:0 auto;height:75px;'>
                            <img src='${ item.imgRoute }' style='width:75px;height:75px;'>
                            <a class='btn btn-primary' href='?page=article-detail/article-detail&id=${ item.id }' role='button' style='width:40px;height:40px;'>
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                        <div style='height:20px;'>
                            ${ name }
                        </div>
                        <div style='height:20px;'>
                            ${ htmlPrice }
                        </div>
                    </div>
                `;
                if(i === data.length - 1) {
                    for(a = 0; a < items_row - (r + 1); a++) {
                        html += `
                            <div class='col-sm tpv-article' style='background-color:transparent; border:none;cursor:default;'></div>
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

    function updateOrder() {
        $.ajax({
            type: "POST",
            url: "php/pages/tpv/crud.tpv.php",
            data: { action: 'currentOrder' },
            success: function(data) {
                data = JSON.parse(data);
                updateTopMenu(data);
                updateTable(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });
    }

    function addArticle(articleId, stock) {
        if(stock <= 0) {
            alert('No existe suficiente Stock para añadir el artículo.');
        } else {
            $.ajax({
                type: "POST",
                url: "php/pages/tpv/crud.tpv.php",
                data: { action: 'addItem', id: articleId },
                success: function(data) {
                    data = JSON.parse(data);
                    updateOrder();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        }
    }

    function deleteArticle(articleId) {
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

    function updateTopMenu(order) {
        // Top Order Lines
        let htmlOrderLines = '';
        order.orderLines.forEach(orderLine => {
            htmlOrderLines += `<a class='dropdown-item' href='#'><span id='shoppingCartLine${ orderLine.articleId }'>${ orderLine.articleName.substr(0, 25) } (${ orderLine.quantity }) ${ orderLine.price }€</span></a>`;
        });
        $('#shoppingCartOrderLines').html(htmlOrderLines);

        // Top Total
        $('#shoppingCartTotalQuantity').html(`(${ order.totalQuantity })`);
        if(order.totalPrice > 0) {
            $('#shoppingCartTotalQuantity').css('color', 'red');
            $('#shoppingCartTotalQuantity').append(` ${ order.totalPrice }€`);
        }
        $('#shoppingCartTotalPrice').html(`Total (${ order.totalQuantity }): ${ order.totalPrice }€`);
    }

    function updateTable(order) {
        $('#blackTotalPrice').html(order.totalPrice);
        $('#blackTotalQuantity').html(order.totalQuantity);

        let tableOrderLines = '';
        if(order && order.orderLines.length > 0) {
            let i = 1;
            order.orderLines.forEach(orderLine => {
                tableOrderLines += `
                <tr>
                    <td>${ i }</td>
                    <td>${ orderLine.articleId }</td>
                    <td>${ orderLine.articleName }</td>
                    <td class='center'>${ orderLine.quantity }</td>
                    <td class='right'>${ orderLine.price }€</td>
                    <td class='right'>${ orderLine.totalPrice }€</td>
                    <td class='center'>
                    <button type='button' class='btn btn-danger btn-sm' onclick='deleteArticle(${ orderLine.articleId });'>
                        <i class='fas fa-trash-alt'></i>
                    </button>
                    </td>
                </tr>
                `;
                i++;
            });
        } else {
            tableOrderLines = '<td colspan="7">No existen artículos en el carrito.</td>';
        }

        $('#tableOrderLines').html(tableOrderLines);
    }
</script>

<div class="row">
    <div class="col-sm-6">
        <div class="tableFixHead" style="height:500px">
            <table class="table-primary table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="background-color:#b8daff;width:30px;" class='center'>#</th>
                        <th style="background-color:#b8daff;width:80px;">Id Artículo</th>
                        <th style="background-color:#b8daff;">Nombre Artículo</th>
                        <th class='center' style="background-color:#b8daff;" class='center'>Cantidad</th>
                        <th class='right' style="background-color:#b8daff;width:80px;">Precio</th>
                        <th class='right' style="background-color:#b8daff;width:80px;">Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tableOrderLines" style="background-color:#fff"></tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="row tpv-black-text-1">
            <div class="col-sm">
                Total: <span id="blackTotalPrice"></span>€&nbsp
            </div>
        </div>
        <div class="row tpv-black-text-2">
            <div class="col-sm">
                Cantidad total: <span id="blackTotalQuantity"></span>
            </div>
        </div>
        <br>
        <div class="tpv-title-module">
            <h4>Categoría: <span id="titleCategory"></span></h4>
        </div>
        <div id="contentCategory" class="scrollDiv" style="height:340px;border:solid 1px #000;"></div>
    </div>
</div>

<hr/>

<div class="tpv-title-module">
    <h4>Artículos</h4>
</div>
<div id="contentArticles" class="scrollDiv" style="height:300px;border:solid 1px #000;"></div>

<hr/>

<div class="row">
    <div class="col-sm">
        <a class='btn btn-primary' href='?page=index' role='button' style='width:80px;height:80px;'>
            <div class="tpv-div-button">
                <i class="fas fa-home"></i>
                <div>Inicio</div>
            </div>
        </a>
        <a class='btn btn-success' href='?page=shoppingCart' role='button' style='width:80px;height:80px;'>
            <div class="tpv-div-button">
                <i class='fas fa-cart-arrow-down'></i>
                <div>Ver carrito</div>
            </div>
        </a>
        <a class='btn btn-danger' href="php/utils/shoppingCart.php?action=deleteItems" role='button' style='width:80px;height:80px;text-align:center;'>
            <div class="tpv-div-button">
                <i class="fas fa-store-slash"></i>
                <div>Vaciar</div>
            </div>
        </a>
    </div>
</div>