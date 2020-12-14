<body>

    <?php include('./php/pages/menus/top_menu.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-0 col-md-1"></div>
            <div class="col-sm-0 col-md-1" style="background-color: red;">
            <?php include("php/pages/menus/left_menu.php"); ?>
            </div>
            <div class="col-sm-12 col-md-8" style="background-color: green;">
                <?php include("php/pages/" . $current_page . ".php"); ?>
            </div>
            <div class="col-sm-0 col-md-1" style="background-color: blue;">
            <?php include("php/pages/menus/right_menu.php"); ?>
            </div>
            <div class="col-sm-0 col-md-1"></div>
        </div>
    </div>

</body>