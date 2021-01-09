<?php

require_once('../../class/User.class.php');

$email = $_POST['email'];
$password = $_POST['password1'];
$firstname = $_POST['firstname'];
$first_lastname = $_POST['first_lastname'];
$second_lastname = $_POST['second_lastname'];
$document = $_POST['document'];
$phone1 = $_POST['phone1'];
$phone2 = $_POST['phone2'];
$address = $_POST['address'];
$location = $_POST['location'];
$province = $_POST['province'];
$country = $_POST['country'];

try {
    $user = new User($firstname, $first_lastname, $second_lastname, $document, $phone1, $phone2, 
                     $address, $location, $province, $country, $email, $password,  User::USER, 1);
    $user->save();
    echo "OK";
} catch (exception $e) {
    echo $e->getMessage();
}

?>