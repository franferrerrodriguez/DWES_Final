<style>
    .tableFixHead {
        overflow: auto;
        height: 100px;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
    }

    div.prueba {
        overflow: scroll;
        overflow-x: hidden;
    }
</style>

<script>
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
                if(data.length) {
                    loadCategories(data);
                    getArticles(categoryId);
                } else {
                    returnCategory.pop();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });
    }

    function loadCategories(data) {
        let items_row = 3;
        if(data.length > 0) {
            let html = '';
            let r = 0;
            let i = 0;
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
                        <div class='col-sm tpv-category' onclick='getCategories(${ item.id })'>
                            ${ item.name }
                        </div>
                    `;
                    if(i === data.length - 1) {
                        for(a = 0; a < items_row - (r + 1); a++) {
                            html += `
                                <div class='col-sm tpv-category' style='background-color:transparent; border:none;cursor:default;'></div>
                            `;
                        }
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
            $('#contentCategory').html(html);
        }
    }

    function btnBackCategories() {
        returnCategory.pop();
        getCategories(returnCategory[returnCategory.length - 1], true);
    }

    function getArticles(categoryId) {
        $.ajax({
            type: "GET",
            url: "php/pages/tpv/crud.tpv.php",
            data: { action: 'articles', id: categoryId },
            success: function(data) {
                data = JSON.parse(data);
                console.log(data);
                //loadArticles(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });
    }

    function loadArticles(data) {
        let items_row = 3;



        let html = '';
        let r = 0;
        let i = 0;


        data.forEach(item => {
                if(r === 0) html += `<div class='row' style='cursor:pointer;'>`;

                html += `
                    <div class='col-sm tpv-category' onclick='getCategories(${ item.id })'>
                        ${ item.name }
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
            $('#contentArticles').html(html);
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
            Total: 110€&nbsp
        </div>
        <br>
        <h4>Categorias:</h4>
        <div id="contentCategory" class="prueba" style="height:340px;border:solid 1px #000;"></div>
    </div>
</div>



<hr/>
<h4>Artículos</h4>
<div id="contentArticles" class="prueba" style="height:300px;border:solid 1px #000;">
    <?php
    $r = 0;
    for($i = 0; $i < 30; $i++) {
        if($r === 0) echo "<div class='row' style='cursor:pointer;'>";
            if($i === 0) {
                echo "<div class='col-sm tpv-category' style='line-height:155px;'>";
                    echo "<i class='fas fa-undo-alt fa-4x'></i>";
                echo "</div>";
            } else {
                echo "<div class='col-sm tpv-category'>";
                    echo "OK";
                echo "</div>";
            }
        if($r === 5) { echo "</div>"; $r = 0; } else { $r++; }
    }
    ?>
</div>






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