<?php

if ($_POST["user"] == "1234" && $_POST["password"] == "1234") {
    session_start();
    $_SESSION["autentificado"] = true;
    header ("Location: ../app/tienda.php");
} else {
    header("Location: ../index.php?errorusuario=si");
}

?>