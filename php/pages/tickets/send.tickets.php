<?php
require_once('../../utils/globalFunctions.php');
require_once('../../class/Ticket.class.php');

$user_id = $_POST["id"];
$issue = $_POST["issue"];
$email = $_POST["email"];
$message = $_POST["message"];

$cm = new Ticket($issue, $email, $message, $user_id, getDateTimeFormat(), Ticket::SENT);
$cm->save();

header("Location: /?page=tickets/tickets");
?>