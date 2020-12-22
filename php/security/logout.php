<?php
include('../utils/global_functions.php');
session_start();
unset($_SESSION['current_session']);
header("Location: ../../?page=" . $default_page);
?>