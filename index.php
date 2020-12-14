<?php

require("./php/utils/global_functions.php");

require_once('php/bbdd/bbdd.php');
$user = "";
$password = "";
if($_SERVER['REMOTE_ADDR'] == "::1") {
    $user = "root";
    $password = "";
} else {
    $user = "frandiab_dwes";
    $password = "7)1cZ8fpbAYu";
}
$bbdd = new BBDD("frandiab_dwes", "localhost", $user, $password);
$bbdd->crearTablas();

?>

<!DOCTYPE html>

<html lang="<?php getKeyVariable("site_lang"); ?>">
    <?php include("./php/templates/header.php"); ?>

    <?php include("./php/templates/body.php"); ?>

    <?php include("./php/templates/footer.php"); ?>
</html>

<?php

echo $bbdd->count("clientes");
$bbdd->cerrarConn();

?>