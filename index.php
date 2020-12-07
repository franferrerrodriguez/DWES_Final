<?php

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
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/lib/bootstrap-4.0.0/css/bootstrap.min.css">
        <script src="assets/lib/bootstrap-4.0.0/js/jquery-3.5.1.min.js"></script>
        <script src="assets/lib/bootstrap-4.0.0/js/popper.min.js"></script>
        <script src="assets/lib/bootstrap-4.0.0/js/bootstrap.min.js"></script>
        <script>
            // Script
        </script>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown link
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            </ul>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-0 col-md-2 col-lg-3" style="background-color: red;">
                One of three columns
            </div>
            <div class="col-sm-12 col-md-8 col-lg-6" style="background-color: green;">
                One of three columns
            </div>
            <div class="col-sm-0 col-md-2 col-lg-3" style="background-color: blue;">
                One of three columns
            </div>
        </div>
        </div>
    </body>
</html>

<?php

echo $bbdd->count("clientes");
$bbdd->cerrarConn();

?>