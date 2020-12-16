
<?php include("php/security/access_control.php"); ?>

<body>
    <?php include('./php/pages/menus/top_menu.php'); ?>

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <div class="col-sm-0 col-md-1"></div>
            <div class="col-sm-0 col-md-3">
                <?php include("php/pages/menus/left_menu.php"); ?>
            </div>
            <div class="col-sm-12 col-md-7">
                <?php include("php/pages/" . $current_page . ".php"); ?>
            </div>
            <div class="col-sm-0 col-md-1"></div>
        </div>
    </div>
</body>