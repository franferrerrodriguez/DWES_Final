<?php
require_once("php/class/User.class.php");
$user = User::getUserSession();
?>

<h2>Tickets</h2>
<hr/>

<?php
if($user) {
?>

<script>

</script>

<form action="php/pages/tickets/send.tickets.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
    <div class="form-group">
        <label for="exampleInputEmail1">Asunto (*):</label>
        <input type="text" name="issue" class="form-control" placeholder="Asunto" required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email (*):</label>
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

<div class="alert alert-success" role="alert" style="float:right;width:80%;text-align:right;">
     [11:32:11] - This is a success alert—check it out!
</div>

<div class="alert alert-dark" role="alert" style="float:left;width:80%;">
    [20:20:12] - This is a dark alert—check it out!
</div>

<?php
} else {
    echo "<h5>Regístrese para poder enviar un ticket al personal de la tienda.</h5><br>";
    echo "<a class='btn btn-success' href='?page=register/register' role='button'>Registrarse</a>";
}
?>