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
$default_page = getDefaultPage();
$current_route = getCurrentRoute();
$current_full_route = getCurrentFullRoute();

function getCurrentRoute() {
    $current_route = getDefaultPage();
    if(isset($_REQUEST['page'])) {
        $current_route = $_REQUEST['page'];
    }
    return $current_route;
}

function getCurrentFullRoute() {
    $current_full_route = "{$_SERVER['REQUEST_URI']}";
    $current_full_route =  explode("?", $current_full_route);
    $current_full_route = count($current_full_route) > 1 ? 
        substr($current_full_route[1], 5, strlen ($current_full_route[1])) : getDefaultPage();
    return $current_full_route;
}

function getDefaultPage() {
    return "index";
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

function getDateTimeFormat($delimDate = "-", $delimHour = ":") {
    $d = getdate();
    return $d["year"] . $delimDate . $d["mon"] . $delimDate . $d["mday"] . " " . $d["hours"] . $delimHour . $d["minutes"] . $delimHour . $d["seconds"];
}

?>