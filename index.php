<?php 
require("./php/utils/global_functions.php"); 
date_default_timezone_set("UTC");
date_default_timezone_set("Europe/Madrid");
?>

<!DOCTYPE html>

<html lang="<?php getKeyVariable("site_lang"); ?>">
    <?php include("./php/templates/header.php"); ?>

    <?php include("./php/templates/body.php"); ?>

    <?php include("./php/templates/footer.php"); ?>
</html>