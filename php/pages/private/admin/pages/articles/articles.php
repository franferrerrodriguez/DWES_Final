<?php
require_once("php/class/Article.class.php");
$articles = Article::getAll();
?>

<script type="text/javascript">
    let articles = [];
    let categories = [];
    let countCategories = 1;
    $(document).ready(function() {
        $('#dataTable').DataTable();

        $('#formaddEdit').on('submit', function(e) {
            e.preventDefault();
            let article = getArticle();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "php/pages/private/admin/pages/articles/crud.articles.php?action=addEdit",
                data: article,
                success: function(data) {
                    if(data === 'OK') {
                        var fd = new FormData();
                        var files = $('#file')[0].files;
                
                        if(files.length > 0 ) {
                            fd.append('id', article.id);
                            fd.append('file', files[0]);

                            $.ajax({
                                url: 'php/pages/private/admin/pages/articles/crud.articles.php?action=uploadImage',
                                type: 'post',
                                data: fd,
                                contentType: false,
                                processData: false,
                                success: function(data) {
                                    if(data === 'OK') {
                                        location.reload();
                                    } else {
                                        $('#modaladdEdit').modal('toggle');
                                        showAlert(data, "danger");
                                    }
                                },
                            });
                        } else {
                            location.reload();
                        }
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
        
        $('#buttondelete').click(function() {
            $.ajax({
                type: "POST",
                url: "php/pages/private/admin/pages/articles/crud.articles.php?action=delete",
                data: getArticle(),
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
        });

        $('#parentArticle option').map(function() { 
            articles.push({
                value: $(this).val(),
                text: $(this).text()
            }); 
        });

        $('#categories_0 option').map(function() { 
            categories.push({
                value: $(this).val(),
                text: $(this).text()
            }); 
        });

        $("#releaseDateValidation").click(function() {
            let today = new Date().toISOString().slice(0, 10);
            if($("#releaseDateValidation").is(":checked")) {
                $("#releaseDate").val(today);
            } else {
                $("#releaseDate").val('0001-01-01');
            }
        });
    });

    function openModal(action, input) {
        let article = null;
        if(input.value) {
            let value = JSON.parse(input.value);
            article = {
                id: value['id'],
                serialNumber: value['serialNumber'],
                brand: value['brand'],
                name: value['name'],
                description: value['description'],
                especification: value['especification'],
                imgRoute: value['imgRoute'],
                price: value['price'],
                priceDiscount: value['priceDiscount'],
                percentageDiscount: value['percentageDiscount'],
                isOutlet: value['isOutlet'],
                freeShipping: value['freeShipping'],
                stock: value['stock'],
                warranty: value['warranty'],
                returnDays: value['returnDays'],
                visitorCounter: value['visitorCounter'],
                releaseDate: value['releaseDate'],
                isActive: value['isActive'],
                categories: value['categories']
            };
        }

        if(action == 'add') {
            $('#modaladdEdit').modal('show');
            $('#modalTitleaddEdit').html('Añadir artículo');
            loadCategories();
        } else if(action == 'edit') {
            $('#modaladdEdit').modal('show');
            $('#modalTitleaddEdit').html('Editar artículo');
            loadCategories(article.categories);
        } else if(action == 'delete') {
            $('#modalTitledelete').html('Eliminar artículo');
            $('#modalContentdelete').html(`¿Está seguro que desea eliminar el artículo ${ article.id }?`);
            $('#confirmdelete').modal('show');
        } else if(action == 'reactive') {
            $('#modalTitledelete').html('Eliminar artículo');
            $('#modalContentdelete').html(`¿Está seguro que desea reactivar el artículo ${ article.id }?`);
            $('#confirmdelete').modal('show');
        }

        fillFields(article);
    }

    function getArticle() {
        let categories = [];
        for(let i = 0; i < countCategories; i++) {
            categories.push($('#categories_' + i).val());
        }
        return {
            id: $('#id').val(),
            serialNumber: $('#serialNumber').val(),
            brand: $('#brand').val(),
            name: $('#name').val(),
            description: $('#description').val(),
            especification: $('#especification').val(),
            price: $('#price').val(),
            priceDiscount: $('#priceDiscount').val(),
            percentageDiscount: $('#percentageDiscount').val(),
            isOutlet: $('#isOutlet').val(),
            freeShipping: $('#freeShipping').val(),
            stock: $('#stock').val(),
            warranty: $('#warranty').val(),
            returnDays: $('#returnDays').val(),
            visitorCounter: $('#visitorCounter').val(),
            releaseDate: $('#releaseDate').val(),
            isActive: $('#isActive').val(),
            categories: categories
        }
    }

    function fillFields(article) {
        $('#id').val(article && article.id ? article.id : '');
        $('#serialNumber').val(article && article.serialNumber ? article.serialNumber : '');
        $('#brand').val(article && article.brand ? article.brand : '');
        $('#name').val(article && article.name ? article.name : '');
        $('#description').val(article && article.description ? article.description : '');
        $('#especification').val(article && article.especification ? article.especification : '');
        $("#img").attr("src", article && article.imgRoute ? article.imgRoute : 'assets/img/common/noimage.png');
        $('#price').val(article && article.price ? article.price : '0');
        $('#priceDiscount').val(article && article.priceDiscount ? article.priceDiscount : '0');
        $('#percentageDiscount').val(article && article.percentageDiscount ? article.percentageDiscount : '0');
        $('#isOutlet').val(article && article.isOutlet ? article.isOutlet : '0');
        $('#freeShipping').val(article && article.freeShipping ? article.freeShipping : '0');
        $('#stock').val(article && article.stock ? article.stock : '0');
        $('#warranty').val(article && article.warranty ? article.warranty : '0');
        $('#returnDays').val(article && article.returnDays ? article.returnDays : '0');
        $('#visitorCounter').val(article && article.visitorCounter ? article.visitorCounter : '0');
        $("#releaseDateValidation").prop('checked', article && article.releaseDate && article.releaseDate !== '0001-01-01');
        $('#releaseDate').val(article && article.releaseDate ? article.releaseDate : '0001-01-01');
        $('#isActive').val(article && article.isActive ? article.isActive : '1');
    }

    function loadCategories(categories = null) {
        $('#categories_0').prop("selectedIndex", 0);
        for(let i = countCategories; i > 1; i--) {
            deleteSelectCategory();
        }
        $(categories).each(function(i, e) {
            if(i > 0) {
                addSelectCategory();
            }
            $('#categories_' + i).val(e.id);
        });
    }

    function addSelectCategory() {
        let options = loadOptionsCategories();
        $('#divSelectCategories').append(`
            <select id="categories_${ countCategories }" class="form-control" style="margin-top: 5px;">
                ${ options }
            </select>
        `);
        countCategories++;
    }

    function deleteSelectCategory() {
        if(countCategories > 1) {
            $('#categories_' + (countCategories - 1)).remove();
            countCategories--;
        }
    }

    function loadOptionsCategories() {
        let result = "";
        categories.forEach(function(value, index) {
            result += `<option value='${ value.value }'>${ value.text }</option>`;
        });
        return result;
    }

    function previewFile() {
        var preview = document.querySelector('#img');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if(file) {
            reader.readAsDataURL(file);
        }else {
            preview.src = "";
        }
    }
</script>

<!-- Tabla listado de artículos -->
<br><h2>Listado de artículos</h2><hr>
<table id="dataTable" class="table-primary table-bordered" style="width:100%">
    <thead>
        <tr>
            <th class='center'>#</th>
            <th>Imagen</th>
            <th>Marca</th>
            <th>Nombre</th>
            <th>Categorías</th>
            <th class='center'>Estado</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($articles) {
                foreach ($articles as $i => $article) {
                    $imgRoute = $article->getImgRoute() ? $article->getImgRoute() : 'assets/img/common/noimage.png';
                    $isActive = $article->isActive() ? 
                        "<span class='badge badge-success'>Activo</span>" : 
                        "<span class='badge badge-danger'>Inactivo</span>";
                    echo "<tr>";
                        echo "<td class='center'>" . ($i + 1) . "</td>";
                        echo "<td class='center'><img style='height:70px;' src='" . $imgRoute . "' alt='" . $imgRoute . "'></td>";
                        echo "<td>" . $article->getBrand() . "</td>";
                        echo "<td>" . $article->getName() . "</td>";
                        echo "<td>";
                            foreach ($article->getCategories() as $index => $category) {
                                echo "<span class='badge badge-info'>" . $category->getName() . "</span>&nbsp";
                            }
                        echo "</td>";
                        echo "<td class='center'>" . $isActive . "</td>";
                        echo "<td class='center'>
                            <button type='button' class='btn btn-success btn-sm' value='" . json_encode_all($article) . "' onclick='openModal(\"edit\", this)'>
                                <i class='fas fa-edit'></i>
                            </button>
                        </td>";
                        if($article->isActive()) {
                            echo "<td class='center'>
                                <button type='button' class='btn btn-danger btn-sm' value='" . json_encode_all($article) . "' onclick='openModal(\"delete\", this)'>
                                    <i class='fas fa-trash-alt'></i>
                                </button>
                            </td>";
                        } else {
                            echo "<td class='center'>
                                <button type='button' class='btn btn-primary btn-sm' value='" . json_encode_all($article) . "' onclick='openModal(\"reactive\", this)'>
                                    <i class='fas fa-redo-alt'></i>
                                </button>
                            </td>";
                        }
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>

<!-- Botón para la ventana Modal de añadir artículos -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-modal-lg" onclick='openModal("add", this)'>
    <i class="fas fa-plus-circle"></i>
    Añadir artículo
</button>

<!-- Ventana Modal para añadir/editar artículos -->
<?php include('modal/addEditArticle.php'); ?>

<!-- Ventana Modal para eliminar artículos -->
<?php include('modal/deleteArticle.php'); ?>