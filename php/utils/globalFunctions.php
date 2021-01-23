<?php

session_start();

// PHP Params
date_default_timezone_set("Europe/Madrid");
header("Content-Type: text/html;charset=utf-8");

$site_lang = "ES";
$site_title = "Tienda online";
$meta_contenttype = "text/html; charset=utf-8";
$meta_description = "Tienda online";
$meta_keywords = "Tienda online";
$default_page = "index";
$current_page = $default_page;
if(isset($_REQUEST['page'])) {
    $current_page = $_REQUEST['page'];
}

function isLogged() {
    return isset($_SESSION["current_session"]);
}

function getLogged() {
    $current_session = null;
    if(isset($_SESSION["current_session"])) {
        $current_session = $_SESSION["current_session"];
    }
    return $current_session;
}

function getKeyVariable($variable) {
    if (isset($GLOBALS[$variable])) {
        echo $GLOBALS[$variable];
    } else {
        echo "Variable missing.";
    }
}

function formatOnlyString($string) {
    $string = str_replace(" ","", $string);
    $string = str_replace(".","", $string);
    $string = str_replace(",","", $string);
    $string = str_replace("(","", $string);
    $string = str_replace(")","", $string);
    return $string;
}

function json_encode_all($obj) {
    $exp = var_export($obj, true);
    $exp = preg_replace('/[a-z0-9_]+\:\:__set_state\(/i','((object)', $exp);
    $enc = create_function('','return json_encode(' . $exp . ');');
    return $enc();
}

function replaceQuotes($string) {
    return str_replace(array('\''), '´', $string);
}

function getDateTimeFormat() {
    $d = getdate();
    return $d["year"] . "-" . $d["mon"] . "-" . $d["mday"] . " " . $d["hours"] . ":" . $d["minutes"] . ":" . $d["seconds"];
}

?>