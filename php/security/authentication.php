<?php

include('../utils/global_functions.php');
include('../class/User.class.php');

$user = User::getByEmail("root@root.com");

if($user && $user->getEmail() == $_POST["email"] && $user->getPassword() == $_POST["password"]) {
    session_start();
    $_SESSION["current_session"] = array(
        "email" => $user->getEmail(),
        "firstName" => $user->getFirstName(),
        "date" => date('Y-m-d H:i:s')
    );
    header("Location: ../../?page=" . $default_page);
} else {
    header("Location: ../../?page=login/login&error=true");
}

?>