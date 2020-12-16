<?php

$tab = "pages/orders";
if(isset($_REQUEST['tab'])) {
    $tab = $_REQUEST['tab'];
}

?>

<h2>Informes</h2>

<br/>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/orders') { echo 'active'; } ?>" 
           href="?page=private/reports/index&tab=pages/orders">Pedidos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/users') { echo 'active'; } ?>" 
           href="?page=private/reports/index&tab=pages/users">Usuarios</a>
    </li>
</ul>

<?php include($tab . '.php'); ?>