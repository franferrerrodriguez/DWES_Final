<?php

$site_lang = "ES";
$site_charset = "UTF-8";
$site_title = "Tienda online";
$meta_description = "Tienda online";
$meta_keywords = "2";
$default_page = "index";
$current_page = $default_page;
if(isset($_REQUEST['page'])) {
    $current_page = $_REQUEST['page'];
}

function getKeyVariable($variable) {
    if (isset($GLOBALS[$variable])) {
        echo $GLOBALS[$variable];
    } else {
        echo "Variable missing.";
    }
}

?>