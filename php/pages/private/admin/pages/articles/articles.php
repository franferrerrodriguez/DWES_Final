<?php
require_once('php/class/Article.class.php');
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
    });

    function openModal(action, input) {
        let article = null;
        if(input.value) {
            let value = JSON.parse(input.value);
            article = {
                id: value['id'],
                serial_number: value['serial_number'],
                brand: value['brand'],
                name: value['name'],
                description: value['description'],
                especification: value['especification'],
                img_route: value['img_route'],
                price: value['price'],
                price_discount: value['price_discount'],
                percentage_discount: value['percentage_discount'],
                is_outlet: value['is_outlet'],
                free_shipping: value['free_shipping'],
                stock: value['stock'],
                warranty: value['warranty'],
                return_days: value['return_days'],
                visitor_counter: value['visitor_counter'],
                release_date: value['release_date'],
                is_active: value['is_active'],
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
            serial_number: $('#serial_number').val(),
            brand: $('#brand').val(),
            name: $('#name').val(),
            description: $('#description').val(),
            especification: $('#especification').val(),
            price: $('#price').val(),
            price_discount: $('#price_discount').val(),
            percentage_discount: $('#percentage_discount').val(),
            is_outlet: $('#is_outlet').val(),
            free_shipping: $('#free_shipping').val(),
            stock: $('#stock').val(),
            warranty: $('#warranty').val(),
            return_days: $('#return_days').val(),
            visitor_counter: $('#visitor_counter').val(),
            release_date: $('#release_date').val(),
            is_active: $('#is_active').val(),
            categories: categories
        }
    }

    function fillFields(article) {
        $('#id').val(article && article.id ? article.id : '');
        $('#serial_number').val(article && article.serial_number ? article.serial_number : '');
        $('#brand').val(article && article.brand ? article.brand : '');
        $('#name').val(article && article.name ? article.name : '');
        $('#description').val(article && article.description ? article.description : '');
        $('#especification').val(article && article.especification ? article.especification : '');
        $("#img").attr("src", article && article.img_route ? article.img_route : 'assets/img/common/noimage.png');
        $('#price').val(article && article.price ? article.price : '0');
        $('#price_discount').val(article && article.price_discount ? article.price_discount : '0');
        $('#percentage_discount').val(article && article.percentage_discount ? article.percentage_discount : '0');
        $('#is_outlet').val(article && article.is_outlet ? article.is_outlet : '0');
        $('#free_shipping').val(article && article.free_shipping ? article.free_shipping : '0');
        $('#stock').val(article && article.stock ? article.stock : '0');
        $('#warranty').val(article && article.warranty ? article.warranty : '0');
        $('#return_days').val(article && article.return_days ? article.return_days : '0');
        $('#visitor_counter').val(article && article.visitor_counter ? article.visitor_counter : '0');
        $('#release_date').val(article && article.release_date ? article.release_date : '0001-01-01');
        $('#is_active').val(article && article.is_active ? article.is_active : '1');
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
        var preview = document.querySelector('img');
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
<table id="dataTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class='center'>#</th>
            <th>Marca</th>
            <th>Nombre</th>
            <th>Precio</th>
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
                    $is_active = $article['is_active'] ? 
                        "<span class='badge badge-success'>Activo</span>" : 
                        "<span class='badge badge-danger'>Inactivo</span>";
                    echo "<tr>";
                        echo "<td class='center'>" . ($i + 1) . "</td>";
                        echo "<td>" . $article['brand'] . "</td>";
                        echo "<td>" . $article['name'] . "</td>";
                        echo "<td>" . $article['price'] . "€</td>";
                        echo "<td>";
                            foreach ($article['categories'] as $index => $category) {
                                echo "<span class='badge badge-info'>" . $category->getName() . "</span>&nbsp";
                            }
                        echo "</td>";
                        echo "<td class='center'>" . $is_active . "</td>";
                        echo "<td class='center'>
                            <button type='button' class='btn btn-success btn-sm' value='" . json_encode_all($article) . "' onclick='openModal(\"edit\", this)'>
                                <i class='fas fa-edit'></i>
                            </button>
                        </td>";
                        echo "<td class='center'>
                            <button type='button' class='btn btn-danger btn-sm' value='" . json_encode($article) . "' onclick='openModal(\"delete\", this)'>
                                <i class='fas fa-trash-alt'></i>
                            </button>
                        </td>";
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