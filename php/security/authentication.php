<?php

include('../utils/globalFunctions.php');
include('../class/User.class.php');
include('../class/Order.class.php');

$email = $_POST['email'];
$password = $_POST['password'];
$user = User::getByEmail($email);

if($user && $user->isActive() && $user->getEmail() == $email && password_verify($password, $user->getPassword())) {
    if(session_id() == '') {
        session_start();
    }
    $_SESSION["current_session"] = array(
        "id" => $user->getId(),
        "email" => $user->getEmail(),
        "firstName" => $user->getFirstName(),
        "date" => date('Y-m-d H:i:s'),
        "rol" => $user->getRol()
    );

    Order::setOrderSessionDB();

    echo "OK";
} else {
    echo "KO";
}

?>