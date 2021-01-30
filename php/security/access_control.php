<?php

require_once("php/class/User.class.php");

$block_employment_views = [
    // Bloqueará el acceso a las vistas asignadas al array cuando es un EMPLEADO
    'private/admin/index'
];

$block_user_views = array_merge($block_employment_views, [
    // Bloqueará el acceso a las vistas asignadas al array cuando es un USUARIO NORMAL
    'private/tickets/index',
    'private/reports/index'
]);


$block_unlogged_views = array_merge($block_user_views, [
    // Bloqueará el acceso a las vistas asignadas al array cuando NO ES LOGUEADO
    //
]);

if((User::isUnlogged() && in_array($current_route, $block_unlogged_views, true)) || 
   (User::isUser() && in_array($current_route, $block_user_views, true)) || 
   (User::isEmployment() && in_array($current_route, $block_employment_views, true))) {
    header("Location: ?page=" . $default_page);
    exit();
}

?>