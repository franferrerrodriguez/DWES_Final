<?php

require_once('../../../../../utils/globalFunctions.php');
require_once('../../../../../class/Order.class.php');
require_once('../../../../../class/User.class.php');

$action = $_POST["action"];
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];

$result = [];
if($action == "ordersDateTable") {
    $result = Order::getAll("date >= '$startDate' AND date <= '$endDate'", "date DESC");
} else if($action == "ordersUserTable") {
    $result = User::getAll("", "id ASC");
    foreach ($result as $i => $user) {
        $user->ordersProcessed = DB::count("ORDERS", " WHERE user_id = " . $user->getId() . " AND status = " . Order::PROCESSED . " AND date >= '$startDate' AND date <= '$endDate'");
        $user->ordersCancelled = DB::count("ORDERS", " WHERE user_id = " . $user->getId() . " AND status = " . Order::CALCELLED . " AND date >= '$startDate' AND date <= '$endDate'");
        $user->ordersReturned = DB::count("ORDERS", " WHERE user_id = " . $user->getId() . " AND status = " . Order::RETURNED . " AND date >= '$startDate' AND date <= '$endDate'");
        $orders = Order::getAll("user_id = " . $user->getId() . " AND date >= '$startDate' AND date <= '$endDate'");
        $totalQuantity = 0;
        $totalPrice = 0;
        foreach ($orders as $i => $order) {
            $totalQuantity += $order->getTotalQuantity();
            $totalPrice += $order->getTotalPrice();
        }
        $user->totalQuantity = round($totalQuantity, 2);
        $user->totalPrice = round($totalPrice, 2);
    }
}

echo json_encode_all($result);
    
?>