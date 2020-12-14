<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio</title>

        <style>
            body {
                text-align:center;
            }
        </style>
    </head>
    <body>
        <h1>Has salido de la aplicación</h1>
        <h2>¡Esperamos volver a verle pronto!</h2>

        <a href="../index.php">Volver al inicio</a>
    </body>
</html>