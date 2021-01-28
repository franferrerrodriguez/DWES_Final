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
            let formValid = true;
            e.preventDefault();
            let user = getUser();

            if(formValid) {
                $.ajax({
                    type: "POST",
                    url: "php/pages/private/tickets/pages/tickets/send.tickets.php",
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
    });

    function openModal(input) {
        let user = null;
        if(input.value) {
            let value = JSON.parse(input.value);
            user = {
                id: value['id'],
                email: value['email'],
                tickets: value['tickets']
            };
        }

        $('#modaladdEdit').modal('show');
        $('#modalTitleaddEdit').html(`Tickets de usuario: ${ user.email }`);
        $('#id').val(user.id);
        $('#email').attr('readonly', true);
        $('#email').val(user.email);

        fillFields(user);
    }

    function getUser() {
        return {
            id: $('#id').val(),
            email: $('#email').val(),
            message: $('#message').val()
        }
    }

    function fillFields(user) {
        $('#tickets').html('');
        if(user && user.tickets) {
            user.tickets.forEach(function(ticket) {
                setTicket(ticket);
            });
        }
    }

    function setTicket(ticket) {
        let color = ticket.answerner ? 'success' : 'dark';
        let style = ticket.answerner ? 'float:right;width:80%;text-align:right;' : 'float:left;width:80%;';

        $(`#tickets`).append(`
            <div class="alert alert-${ color }" role="alert" style="${ style }">
                <i>${ ticket.email } - (${ ticket.date })</i><br>${ ticket.message }
            </div>
        `);
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
            <th class='center'>Leídos</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($users) {
                foreach ($users as $i => $user) {
                    $tickets = Ticket::getUserTickets($user->getId());
                    $user->tickets = $tickets;
                    $not_viewed = Ticket::getUserNotViewedTickets($user->getId());

                    if($not_viewed) {
                        $not_viewed_color = "danger";
                    } else {
                        $not_viewed_color = "success";
                    }

                    echo "<tr>";
                        echo "<td class='center'>" . ($i + 1) . "</td>";
                        echo "<td>" . $user->getFirstName() . "</td>";
                        echo "<td>" . $user->getFirstLastName() . " " . $user->getSecondLastName() . "</td>";
                        echo "<td>" . $user->getDocument() . "</td>";
                        echo "<td>" . $user->getEmail() . "</td>";
                        echo "<td class='center'><span class='badge badge badge-$not_viewed_color'>" . (count($tickets) - $not_viewed) . "/" . count($tickets) . "</span></td>";
                        echo "<td class='center'>
                            <button type='button' class='btn btn-success btn-sm' value='" . json_encode_all($user) . "' onclick='openModal(this)'>
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