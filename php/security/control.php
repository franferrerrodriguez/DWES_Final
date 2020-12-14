<?php

$private_views = [
    'page3',
    'page4'
];

session_start();

if (in_array($current_page, $private_views, true) && !$_SESSION["admin"]) {
    header("Location: ?page=" . $default_page);
    exit();
}

?>