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
            $.ajax({
                type: "POST",
                url: "php/pages/private/admin/pages/categories/crud.categories.php?action=addEdit",
                data: getCategory(),
                success: function(data) {
                    data = JSON.parse(data);
                    if(!data.responseError) {
                        location.reload();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        });
        
        $('#buttondelete').click(function() {
            $.ajax({
                type: "POST",
                url: "php/pages/private/admin/pages/categories/crud.categories.php?action=delete",
                data: getCategory(),
                success: function(data) {
                    data = JSON.parse(data);
                    if(!data.responseError) {
                        location.reload();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        });

        $('#parentCategory option').map(function() { 
            categories.push({
                value: $(this).val(),
                text: $(this).text()
            }); 
        });
    });

    function openModal(action, input) {
        let category = null;
        if(input.value) {
            let value = JSON.parse(input.value);
            category = {};
            category.id = value[0];
            category.name = value[1];
            category.description = value[2];
            category.isActive = value[3];
            category.parentCategory = value[4];
        }

        if(action== 'add') {
            $('#modaladdEdit').modal('show');
            $('#modalTitleaddEdit').html('Añadir categoría');
        } else if(action == 'edit') {
            $('#modaladdEdit').modal('show');
            $('#modalTitleaddEdit').html('Editar categoría');
        } else if(action == 'delete') {
            $('#modalTitledelete').html('Eliminar categoría');
            $('#modalContentdelete').html(`¿Está seguro que desea eliminar la categoría ${ category.id }?`);
            $('#confirmdelete').modal('show');
        }

        fillFields(category);
    }

    function getCategory() {
        return {
            id: $('#id').val(),
            name: $('#name').val(),
            description: $('#description').val(),
            isActive: $('#isActive').val(),
            parentCategory: $('#parentCategory').val()
        }
    }

    function fillFields(category) {
            $('#id').val(category && category.id ? category.id : '');
            $('#name').val(category && category.name ? category.name : '');
            $('#description').val(category && category.description ? category.description : '');
            $('#isActive').val(category && category.isActive ? category.isActive : '1');
            $('#parentCategory').val(category && category.parentCategory ? category.parentCategory : '');
        
        loadSelectCategory(category);
    }

    function loadSelectCategory(category) {
        $("#parentCategory").html('');
        $(categories).each(function(i, e) {
            if(!category || category.id !== e.value) {
                $("#parentCategory").append(`<option value='${ e.value }'>${ e.text }</option>`);
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
                    $parent_name = $parent ? $parent->getName() : "N/A";
                    echo "<tr>";
                        echo "<td>" . ($i + 1) . "</td>";
                        echo "<td>" . $category['name'] . "</td>";
                        echo "<td>" . $category['description'] . "</td>";
                        echo "<td>" . $category['is_active'] . "</td>";
                        echo "<td>" . $parent_name . "</td>";
                        echo "<td>
                            <button type='button' class='btn btn-success btn-sm' value='" . json_encode($category) . "' onclick='openModal(\"edit\", this)'>
                                <i class='fas fa-edit'></i>
                            </button>
                        </td>";
                        echo "<td>
                            <button type='button' class='btn btn-danger btn-sm' value='" . json_encode($category) . "' onclick='openModal(\"delete\", this)'>
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
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-modal-lg" onclick='openModal("add", this)'>
    <i class="fas fa-plus-circle"></i>
    Añadir categoría
</button>

<!-- Ventana Modal para añadir/editar categorías -->
<?php include('modal/addEditCategory.php'); ?>

<!-- Ventana Modal para eliminar categorías -->
<?php include('modal/deleteCategory.php'); ?>