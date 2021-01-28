<?php

require_once('../../../../../class/User.class.php');

$action = $_REQUEST['action'];
$id = $_POST["id"];

if($action === "addEdit") {
    $firstName = $_POST["firstName"];
    $firstLastName = $_POST["firstLastName"];
    $secondLastName = $_POST["secondLastName"];
    $document = $_POST["document"];
    $phone1 = $_POST["phone1"];
    $phone2 = $_POST["phone2"];
    $address = $_POST["address"];
    $location = $_POST["location"];
    $province = $_POST["province"];
    $country = $_POST["country"];
    $email = $_POST["email"];
    $password = $_POST["password1"];
    $rol = $_POST["rol"];
    $isActive = $_POST["isActive"];
    
    if(!$id) {
        try {
            $user = new User($firstName, $firstLastName, $secondLastName, $document, $phone1, $phone2, $address, $location, $province, $country, $email, $password, $rol, $isActive);
            $user->save();
            echo "OK";
        } catch (exception $e) {
            echo $e->getMessage();
        }
    } else {
        $user = User::getById($id);
        $user->setFirstName($firstName);
        $user->setFirstLastName($firstLastName);
        $user->setSecondLastName($secondLastName);
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
        $user->setRol($rol);
        $user->setActive($isActive);

        try {
            $user->update();
            echo "OK";
        } catch (exception $e) {
            echo $e->getMessage();
        }
    }
} else if($action === "delete") {
    try {
        // User::delete($id);
        $user = User::getById($id);
        $user->setActive(!$user->isActive());
        $user->update();
        echo "OK";
    } catch (exception $e) {
        echo $e->getMessage();
    }
}

?>