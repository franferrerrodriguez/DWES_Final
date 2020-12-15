<?php
//unset($_SESSION['current_session']);
$session = null;
if(isset($_SESSION["current_session"])) {
    $session = $_SESSION["current_session"];
}
//var_dump($session);
if(!$session) {
?>
<form action="php/security/authentication.php" method="POST">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu email">
    </div>
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Recuérdame</label>
    </div>
    <br>
    <input class="btn btn-primary" type="submit" value="Acceder">
    <input class="btn btn-secondary" type="reset" value="Borrar">
</form>
<?php
} else {
?>

LOGUEADO

<?php
}
?>