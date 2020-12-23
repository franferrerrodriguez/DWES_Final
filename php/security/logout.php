<?php
include('../utils/globalFunctions.php');

if(session_id() == '') {
    session_start();
}

unset($_SESSION['current_session']);
header("Location: ../../?page=" . $default_page);
?>