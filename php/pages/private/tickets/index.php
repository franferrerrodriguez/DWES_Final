<?php

$tab = "pages/tickets/tickets";
if(isset($_REQUEST['tab'])) {
    $tab = $_REQUEST['tab'];
}

?>

<h2>Gestión de Tickets</h2>

<br/>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php if($tab == 'pages/tickets/tickets') { echo 'active'; } ?>" 
           href="?page=private/reports/index&tab=pages/tickets/tickets">Tickets</a>
    </li>
</ul>

<?php include($tab . '.php'); ?>