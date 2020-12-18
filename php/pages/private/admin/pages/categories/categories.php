<?php
require_once('php/class/Category.class.php');
$categories = Category::getAll();
?>

<script type="text/javascript">
    let categories = [];
    $(document).ready(function() {
        $('#dataTable').DataTable();

        $('#formaddEdit').on('submit', function(e){
            e.preventDefault();
        });

        $('#buttonaddEdit, #buttondelete').click(function() {
            $.ajax({
                type: "POST",
                url: "php/pages/private/admin/pages/categories/crud.categories.php",
                data: $("#form").serialize(),
                success: function(data) {
                    console.log(data);
                    //data = JSON.parse(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        });

        $('#subcategories option').map(function() { 
            categories.push({
                value: $(this).val(),
                text: $(this).text()
            }); 
        });
    });

    function prueba(action, input) {
        let category = null;
        if(input.value) {
            let value = JSON.parse(input.value);
            category = {};
            category.id = value[0];
            category.name = value[1];
            category.description = value[2];
            category.isActive = value[3];
            category.subCategoryId = value[4];
        }

        if(action== 'add') {
            $('#addEdit').modal('show');
            $('#modalTitleaddEdit').html('Añadir categoría');
        } else if(action == 'edit') {
            $('#addEdit').modal('show');
            $('#modalTitleaddEdit').html('Editar categoría');
        } else if(action == 'delete') {
            $('#modalTitledelete').html('Eliminar categoría');
            $('#modalContentdelete').html(`¿Está seguro que desea eliminar la categoría ${ category.id }?`);
            $('#delete').modal('show');
        }

        fillFields(category);
    }

    function fillFields(category) {
        if(category) {
            $('#id').val(category.id ? category.id : '');
            $('#name').val(category.name ? category.name : '');
            $('#description').val(category.description ? category.description : '');
            $('#isActive').val(category.isActive ? category.isActive : '');
            $('#subcategories').val(category.subCategoryId ? category.subCategoryId : '');
        }
        loadSelectCategory(category);
    }

    function loadSelectCategory(category) {
        $("#subcategories").html('');
        $(categories).each(function(i, e) {
            if(!category || category.id !== e.value) {
                $("#subcategories").append(`<option value='${ e.value }'>${ e.text }</option>`);
            }
        });
    }
</script>

<!-- Tabla listado de categorías -->
<br><h2>Listado de categorías</h2><hr>
<table id="dataTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Activo</th>
            <th>Padre</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($categories) {
                foreach ($categories as $i => $category) {
                    $parent = Category::getById($category['category_id']);
                    $parent_name = $parent ? $parent[0]['name'] : "N/A";
                    echo "<tr>";
                        echo "<td>" . ($i + 1) . "</td>";
                        echo "<td>" . $category['name'] . "</td>";
                        echo "<td>" . $category['description'] . "</td>";
                        echo "<td>" . $category['is_active'] . "</td>";
                        echo "<td>" . $parent_name . "</td>";
                        echo "<td>
                            <button type='button' class='btn btn-success btn-sm' value='" . json_encode($category) . "' onclick='prueba(\"edit\", this)'>
                                <i class='fas fa-edit'></i>
                            </button>
                        </td>";
                        echo "<td>
                            <button type='button' class='btn btn-danger btn-sm' value='" . json_encode($category) . "' onclick='prueba(\"delete\", this)'>
                                <i class='fas fa-trash-alt'></i>
                            </button>
                        </td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>

<!-- Botón para la ventana Modal de añadir categorías -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-modal-lg" onclick='prueba("add", this)'>
    <i class="fas fa-plus-circle"></i>
    Añadir categoría
</button>

<!-- Ventana Modal para añadir/editar categorías -->
<?php include('modal/addEditCategory.php'); ?>

<!-- Ventana Modal para eliminar categorías -->
<?php include('modal/deleteCategory.php'); ?>