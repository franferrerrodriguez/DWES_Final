<?php

require_once("php/class/User.class.php");

// Bloqueará el acceso a las vistas asignadas al array
$block_user_views = [
    'private/admin/index'
];

$block_employment_views = [

];

$block_admin_views = [

];

if((User::isUser() && in_array($current_page, $block_user_views, true)) || 
   (User::isEmployment() && in_array($current_page, $block_employment_views, true)) || 
   (User::isAdmin() && in_array($current_page, $block_admin_views, true))) {
    header("Location: ?page=" . $default_page);
    exit();
}

?>