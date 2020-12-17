<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable();

        $("button").click(function() {
            let action = this.id.split('_')[0];
            let id = this.id.split('_')[1];

            if(action == 'add') {
                $('#addEdit').modal('show');
                $('#modalTitleaddEdit').html('Añadir categoría');

            } else if(action == 'edit') {
                $('#addEdit').modal('show');
                $('#modalTitleaddEdit').html('Editar categoría');
                $('#inputEmail4').val(id);

                $("#selectCategories option[value='1']").each(function() {
                    $(this).remove();
                });

            }else if(action == 'delete') {
                $('#modalTitledelete').html('Eliminar categoría');
                $('#modalContentdelete').html("¿Está seguro que desea eliminar la categoría " + id + "?");
                $('#delete').modal('show');

                console.log(action + " - " + id);
            }
        });
    });
</script>

<br>

<h2>Listado de categorías</h2>

<hr>

<?php

require_once('php/class/Category.class.php');

$categories = Category::getAll();

?>

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
                            <button type='button' class='btn btn-success btn-sm' id='edit_" . $category['id'] . "'>
                                <i class='fas fa-edit'></i>
                            </button>
                        </td>";
                        echo "<td>
                            <button type='button' class='btn btn-danger btn-sm' id='delete_" . $category['id'] . "'>
                                <i class='fas fa-trash-alt'></i>
                            </button>
                        </td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>

<?php include('modal/deleteCategory.php'); ?>

<button type="button" id="add_0" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">
    <i class="fas fa-plus-circle"></i>
    Añadir categoría
</button>
<?php include('modal/addEditCategory.php'); ?>