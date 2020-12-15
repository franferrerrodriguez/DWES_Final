<?php

include('../utils/global_functions.php');
include('../class/User.class.php');

$email = $_POST['email'];
$password = $_POST['password'];
$user = User::getByEmail($email);

if($user && $user->getEmail() == $email && $user->getPassword() == $password) {
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