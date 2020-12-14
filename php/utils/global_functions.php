<?php

    $uri = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $site_lang = "ES";
    $site_charset = "UTF-8";
    $site_title = "Tienda online";
    $meta_description = "Tienda online";
    $meta_keywords = "2";
    $current_page = "page1";
    if(isset($_REQUEST['page'])) {
        $current_page = "page" . $_REQUEST['page'];
    }

    function getKeyVariable($variable) {
        if (isset($GLOBALS[$variable])) {
            echo $GLOBALS[$variable];
        } else {
            echo "Variable missing.";
        }
    }

?>