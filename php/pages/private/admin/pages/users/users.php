<?php
require_once("php/class/User.class.php");
$users = User::getAll();
?>

<script type="text/javascript">
    let users = [];
    $(document).ready(function() {
        $('#dataTable').DataTable();

        $('#formaddEdit').on('submit', function(e) {
            let formValid = true;
            e.preventDefault();
            let user = getUser();

            if(!validateDocument(user.document)) { // Validamos documento
                formValid = false;
                resetFields();
                showAlert("El número de documento no contiene un formato válido.", "danger", "modalAlert");
            } else if(user.password1 || user.password2) { // Validamos contraseñas
                if(user.password1 !== user.password2) {
                    formValid = false;
                    resetFields();
                    showAlert("Las contraseñas introducidas no coinciden. Por favor, vuelva a intentarlo.", "danger", "modalAlert");
                } else if(user.password1.length < 4) {
                    formValid = false;
                    resetFields();
                    showAlert("La longitud de la contraseña debe ser igual o superior a 4 dígitos.", "danger", "modalAlert");
                }
            }

            if(formValid) {
                $.ajax({
                    type: "POST",
                    url: "php/pages/private/admin/pages/users/crud.users.php?action=addEdit",
                    data: user,
                    success: function(data) {
                        if(data === 'OK') {
                            location.reload();
                        } else {
                            resetFields();
                            $('#modaladdEdit').modal('toggle');
                            showAlert(data, "danger");
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        resetFields();
                        $('#modaladdEdit').modal('toggle');
                        showAlert("Ha ocurrido un error inesperado.", "danger");
                    }
                });
            }
        });
        
        $('#buttondelete').click(function() {
            $.ajax({
                type: "POST",
                url: "php/pages/private/admin/pages/users/crud.users.php?action=delete",
                data: getUser(),
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
    });

    function openModal(action, input) {
        let user = null;
        resetFields();
        if(input.value) {
            let value = JSON.parse(input.value);
            console.log(value);
            user = {
                id: value['id'],
                firstname: value['firstname'],
                first_lastname: value['first_lastname'],
                second_lastname: value['second_lastname'],
                document: value['document'],
                phone1: value['phone1'],
                phone2: value['phone2'],
                address : value['address'],
                location : value['location'],
                province: value['province'],
                country: value['country'],
                email: value['email'],
                rol: value['rol'],
                is_active: value['is_active']
            };
        }

        if(action == 'add') {
            $('#modaladdEdit').modal('show');
            $('#modalTitleaddEdit').html('Añadir usuario');
            $('#email').attr('readonly', false);
        } else if(action == 'edit') {
            $('#modaladdEdit').modal('show');
            $('#modalTitleaddEdit').html('Editar usuario');
            $('#email').attr('readonly', true);
        } else if(action == 'delete') {
            $('#modalTitledelete').html('Eliminar usuario');
            $('#modalContentdelete').html(`¿Está seguro que desea eliminar el usuario ${ user.id }?`);
            $('#confirmdelete').modal('show');
        } else if(action == 'reactive') {
            $('#modalTitledelete').html('Eliminar usuario');
            $('#modalContentdelete').html(`¿Está seguro que desea reactivar el usuario ${ user.id }?`);
            $('#confirmdelete').modal('show');
        }

        fillFields(user);
    }

    function getUser() {
        return {
            id: $('#id').val(),
            email: $('#email').val(),
            password1: $('#password1').val(),
            password2: $('#password2').val(),
            firstname: $('#firstname').val(),
            first_lastname: $('#first_lastname').val(),
            second_lastname: $('#second_lastname').val(),
            document: $('#document').val(),
            phone1: $('#phone1').val(),
            phone2: $('#phone2').val(),
            address: $('#address').val(),
            location: $('#location').val(),
            province: $('#province').val(),
            country: $('#country').val(),
            is_active: $('#is_active').val(),
            rol: $('#rol').val()
        }
    }

    function resetFields() {
        $('#document').val('');
        $('#password1').val('');
        $('#password2').val('');
        $('#modalAlert').html('');
    }

    function fillFields(user) {
        $('#id').val(user && user.id ? user.id : '');
        $('#email').val(user && user.email ? user.email : '');
        $('#firstname').val(user && user.firstname ? user.firstname : '');
        $('#first_lastname').val(user && user.first_lastname ? user.first_lastname : '');
        $('#second_lastname').val(user && user.second_lastname ? user.second_lastname : '');
        $('#document').val(user && user.document ? user.document : '');
        $('#phone1').val(user && user.phone1 ? user.phone1 : '');
        $('#phone2').val(user && user.phone2 ? user.phone2 : '');
        $('#address').val(user && user.address ? user.address : '');
        $('#location').val(user && user.location ? user.location : '');
        $('#province').val(user && user.province ? user.province : '');
        $('#country').val(user && user.country ? user.country : '');
        $('#is_active').val(user && user.is_active ? user.is_active : '1');
        $('#rol').val(user && user.rol ? user.rol : '0');
    }
</script>

<!-- Tabla listado de usuarios -->
<br><h2>Listado de usuarios</h2><hr>
<table id="dataTable" class="table-primary table-bordered" style="width:100%">
    <thead>
        <tr>
            <th class='center'>#</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Documento</th>
            <th>Email</th>
            <th class='center'>Estado</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($users) {
                foreach ($users as $i => $user) {
                    $is_active = $user['is_active'] ? 
                        "<span class='badge badge-success'>Activo</span>" : 
                        "<span class='badge badge-danger'>Inactivo</span>";
                    echo "<tr>";
                        echo "<td class='center'>" . ($i + 1) . "</td>";
                        echo "<td>" . $user['firstname'] . "</td>";
                        echo "<td>" . $user['first_lastname'] . " " . $user['second_lastname'] . "</td>";
                        echo "<td>" . $user['document'] . "</td>";
                        echo "<td>" . $user['email'] . "</td>";
                        echo "<td class='center'>" . $is_active . "</td>";
                        echo "<td class='center'>
                            <button type='button' class='btn btn-success btn-sm' value='" . json_encode($user) . "' onclick='openModal(\"edit\", this)'>
                                <i class='fas fa-edit'></i>
                            </button>
                        </td>";
                        if($user["is_active"]) {
                            echo "<td class='center'>
                                <button type='button' class='btn btn-danger btn-sm' value='" . json_encode($user) . "' onclick='openModal(\"delete\", this)'>
                                    <i class='fas fa-trash-alt'></i>
                                </button>
                            </td>";
                        } else {
                            echo "<td class='center'>
                                <button type='button' class='btn btn-primary btn-sm' value='" . json_encode($user) . "' onclick='openModal(\"reactive\", this)'>
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

<!-- Botón para la ventana Modal de añadir usuarios -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-modal-lg" onclick='openModal("add", this)'>
    <i class="fas fa-plus-circle"></i>
    Añadir usuario
</button>

<!-- Ventana Modal para añadir/editar usuarios -->
<?php include('modal/addEditUser.php'); ?>

<!-- Ventana Modal para eliminar usuarios -->
<?php include('modal/deleteUser.php'); ?>