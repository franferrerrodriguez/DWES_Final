<?php

include('../utils/global_functions.php');
include('../class/User.class.php');

$email = $_POST['email'];
$password = $_POST['password'];
$user = User::getByEmail($email);

//echo password_hash("1234", PASSWORD_DEFAULT);

if($user && $user->getEmail() == $email && password_verify($password, $user->getPassword())) {
    if(session_id() == '') {
      session_start();
    }
    $_SESSION["current_session"] = array(
        "email" => $user->getEmail(),
        "firstName" => $user->getFirstName(),
        "date" => date('Y-m-d H:i:s'),
        "rol" => $user->getRol()
    );
    echo json_encode(["responseError" => false, "sessionData" => $_SESSION["current_session"]]);
} else {
    echo json_encode(["responseError" => true, "sessionData" => null]);
}

?>