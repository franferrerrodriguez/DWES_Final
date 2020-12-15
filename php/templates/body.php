
<?php include("php/security/control.php"); ?>

<body>
    <?php include('./php/pages/menus/top_menu.php'); ?>

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <div class="col-sm-0 col-md-3">
                <?php include("php/pages/menus/left_menu.php"); ?>
            </div>
            <div class="col-sm-12 col-md-6">
                <?php include("php/pages/" . $current_page . ".php"); ?>
            </div>
            <div class="col-sm-0 col-md-3" style="background-color: blue;">
                <?php include("php/pages/menus/right_menu.php"); ?>
            </div>
        </div>
    </div>
</body>