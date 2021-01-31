<?php  require("./php/utils/globalFunctions.php"); ?>

<?php
    require_once("php/class/Order.class.php");
    $order = Order::getMapCookieShoppingCart();
    setcookie("shopping_cart", json_encode_all($order), time() + 3600, "/");
?>

<!DOCTYPE html>
<html lang="<?php getKeyVariable("site_lang"); ?>">
    <div id="header">
        <?php include("./php/templates/header.php"); ?>
    </div>
    <div id="body">
        <?php include("./php/templates/body.php"); ?>
    </div>
    <div id="footer">
        <?php include("./php/templates/footer.php"); ?>
    </div>
</html>