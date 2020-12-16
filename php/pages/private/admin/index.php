<?php

$tab = "admin-categories";
if(isset($_REQUEST['tab'])) {
    $tab = $_REQUEST['tab'];
}

?>

<h2>Administración (CMS)</h2>

<br/>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'admin-categories') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=admin-categories">Categorías</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'admin-articles') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=admin-articles">Artículos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'admin-users') { echo 'active'; } ?>" 
           href="?page=private/admin/index&tab=admin-users">Usuarios</a>
    </li>
</ul>

<?php include($tab . '.php'); ?>