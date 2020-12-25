<?php

require_once('../../../class/User.class.php');

$id = $_POST["id"];

$firstname = $_POST["firstname"];
$first_lastname = $_POST["first_lastname"];
$second_lastname = $_POST["second_lastname"];
$document = $_POST["document"];
$phone1 = $_POST["phone1"];
$phone2 = $_POST["phone2"];
$address = $_POST["address"];
$location = $_POST["location"];
$province = $_POST["province"];
$country = $_POST["country"];
$email = $_POST["email"];
$password = $_POST["password1"];

$user = User::getById($id);
$user->setFirstName($firstname);
$user->setFirstLastName($first_lastname);
$user->setSecondLastName($second_lastname);
$user->setDocument($document);
$user->setPhone1($phone1);
$user->setPhone2($phone2);
$user->setAddress($address);
$user->setLocation($location);
$user->setProvince($province);
$user->setCountry($country);
$user->setEmail($email);
if($password) {
    $user->setEncryptPassword($password);
} else {
    $user->setPassword($user->getPassword());
}

$user->update();
echo "OK";

?>