<?php
require_once("php/class/User.class.php");
require_once("php/class/Ticket.class.php");
$user = User::getUserSession();
?>

<h2>Tickets</h2>
<hr/>

<?php
if($user) {
?>

<script>
    function setTicket(ticket) {
        let color = ticket.user_to ? 'success' : 'dark';
        let style = ticket.user_to ? 'float:right;width:80%;text-align:right;' : 'float:left;width:80%;';

        $(`#tickets`).append(`
            <div class="alert alert-${ color }" role="alert" style="${ style }">
                <i>(${ ticket.date })</i><br>${ ticket.message }
            </div>
        `);
    }
</script>

<form action="php/pages/tickets/send.tickets.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
    <div class="form-group">
        <label for="exampleInputEmail1">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php echo $user->getEmail(); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Mensaje (*):</label>
        <textarea class="form-control" name="message" rows="4" placeholder="Mensaje" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    <button type="reset" class="btn btn-secondary">Borrar</button>
</form>

<hr/>

<?php
foreach (Ticket::getUserTickets($user->getId()) as $index => $ticket) {
    if(!$ticket["answerner"]) {
        echo "<div class='alert alert-success' role='alert' style='float:right;width:80%;text-align:right;'>";
            echo "<i>" . $ticket["email"] . " - (" . $ticket["date"] . ")</i><br>" . $ticket["message"];
        echo "</div>";
    } else {
        echo "<div class='alert alert-dark' role='alert' style='float:left;width:80%;'>";
            echo "<i>" . $ticket["email"] . " - (" . $ticket["date"] . ")</i><br>" . $ticket["message"];
        echo "</div>";
    }
}
?>

<?php
} else {
    echo "<h5>Acceda o regístrese para poder enviar un ticket de soporte.</h5><hr/>";
    echo "<a class='btn btn-primary' href='?page=login' role='button'>Ingresar</a>&nbsp";
    echo "<a class='btn btn-success' href='?page=register/register' role='button'>Registrarse</a>";
}
?>