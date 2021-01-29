<?php  require("./php/utils/globalFunctions.php"); ?>

<?php
    require_once("php/class/Order.class.php");
    $order = Order::getMapCookieShoppingCart();
    setcookie("shopping_cart", json_encode_all($order), time() + 3600, "/");
?>

<!DOCTYPE html>
<html lang="<?php getKeyVariable("site_lang"); ?>">
    <?php include("./php/templates/header.php"); ?>

    <?php include("./php/templates/body.php"); ?>

    <?php include("./php/templates/footer.php"); ?>
</html>