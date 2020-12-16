<?php

$tab = "pages/categories";
if(isset($_REQUEST['tab'])) {
    $tab = $_REQUEST['tab'];
}

?>

<h2>Administración (CMS)</h2>

<br/>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/categories') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=pages/categories">Categorías</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/articles') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=pages/articles">Artículos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/orders') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=pages/orders">Pedidos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/users') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=pages/users">Usuarios</a>
    </li>
</ul>

<?php include($tab . '.php'); ?>