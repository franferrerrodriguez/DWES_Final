<?php

$tab = "pages/orders/orders";
if(isset($_REQUEST['tab'])) {
    $tab = $_REQUEST['tab'];
}

?>

<h2>Informes</h2>

<br/>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/orders/orders') { echo 'active'; } ?>" 
           href="?page=private/reports/index&tab=pages/orders/orders">Pedidos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/articles/articles') { echo 'active'; } ?>" 
           href="?page=private/reports/index&tab=pages/articles/articles">Artículos</a>
    </li>
</ul>

<?php include($tab . '.php'); ?>