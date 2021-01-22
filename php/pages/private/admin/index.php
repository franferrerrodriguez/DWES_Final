<?php

require_once("php/security/access_control.php");

$tab = "pages/categories/categories";
if(isset($_REQUEST['tab'])) {
    $tab = $_REQUEST['tab'];
}

?>

<h2>Administración</h2>

<br/>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/categories/categories') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=pages/categories/categories">Categorías</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/articles/articles') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=pages/articles/articles">Artículos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/users/users') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=pages/users/users">Usuarios</a>
    </li>
</ul>

<?php include($tab . '.php'); ?>