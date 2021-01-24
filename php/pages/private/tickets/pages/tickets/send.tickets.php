<?php
require_once("../../../../../utils/globalFunctions.php");
require_once("../../../../../class/Ticket.class.php");
require_once("../../../../../class/User.class.php");

$questioner = $_POST["id"];
$user = User::getUserSession();
$answerner = $user->getId();
$message = $_POST["message"];

$cm = new Ticket($user->getEmail(), $message, getDateTimeFormat(), $questioner, $answerner);
$cm->save();

echo "OK";

?>