<?php
require_once('../../utils/globalFunctions.php');
require_once('../../class/Ticket.class.php');

$questioner = $_POST["id"];
$email = $_POST["email"];
$message = $_POST["message"];

$cm = new Ticket($email, $message, getDateTimeFormat(), $questioner, null);
$cm->save();

header("Location: /?page=tickets/tickets");
?>