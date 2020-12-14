<?php
include('../utils/global_functions.php');
session_start();
session_destroy();
header("Location: ../../?page=" . $default_page);
?>