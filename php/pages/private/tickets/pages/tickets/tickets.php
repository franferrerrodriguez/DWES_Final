<?php
require_once("php/class/User.class.php");
require_once("php/class/Ticket.class.php");
$users = User::getAll();
?>

<script type="text/javascript">
    let users = [];
    $(document).ready(function() {
        $('#dataTable').DataTable();

        $('#formaddEdit').on('submit', function(e) {
            /*let formValid = true;
            e.preventDefault();
            let user = getUser();

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
            }*/
        });
    });

    function openModal(input) {
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

        $('#modaladdEdit').modal('show');
        $('#modalTitleaddEdit').html(`Tickets de usuario (${ user.email })`);
        $('#email').attr('readonly', true);
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
        // REFRESCAR MENSAJES
    }
</script>

<!-- Tabla listado de usuarios -->
<br>
<table id="dataTable" class="table-primary table-bordered" style="width:100%">
    <thead>
        <tr>
            <th class='center'>#</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Documento</th>
            <th>Email</th>
            <th>Nº tickets</th>
            <th>Sin leer</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($users) {
                foreach ($users as $i => $user) {
                    $tickets = Ticket::getAllByUserId($user["id"]);
                    $user["tickets"] = $tickets;
                    echo "<tr>";
                        echo "<td class='center'>" . ($i + 1) . "</td>";
                        echo "<td>" . $user['firstname'] . "</td>";
                        echo "<td>" . $user['first_lastname'] . " " . $user['second_lastname'] . "</td>";
                        echo "<td>" . $user['document'] . "</td>";
                        echo "<td>" . $user['email'] . "</td>";
                        echo "<td>0</td>";
                        echo "<td>0</td>";
                        echo "<td class='center'>
                            <button type='button' class='btn btn-success btn-sm' value='" . json_encode($user) . "' onclick='openModal(this)'>
                                <i class='fas fa-envelope'></i>
                            </button>
                        </td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>

<!-- Ventana Modal para añadir/editar usuarios -->
<?php include('modal/showTicket.php'); ?>