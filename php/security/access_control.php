<?php

// Bloqueará el acceso a las vistas asignadas al array
$block_user_views = [
    'private/admin/index'
];

$block_employment_views = [

];

$block_admin_views = [

];

if(($isUser && in_array($current_page, $block_user_views, true)) || 
   ($isEmployment && in_array($current_page, $block_employment_views, true)) || 
   ($isAdmin && in_array($current_page, $block_admin_views, true))) {
    header("Location: ?page=" . $default_page);
    exit();
}

?>