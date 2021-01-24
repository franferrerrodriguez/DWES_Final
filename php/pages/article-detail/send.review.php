<?php

require_once('../../utils/globalFunctions.php');
require_once('../../class/Review.class.php');
require_once('../../class/User.class.php');

$user = User::getUserSession();
$articleId = $_POST["id"];
$title = $_POST["title"];
$description = $_POST["description"];
$rating = $_POST["rating"];

$review = new Review($title, $description, $rating, getDateTimeFormat(), $articleId, $user->getId());
$review->save();

echo "OK";

?>