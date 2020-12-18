
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
        <div class="row">
            <div class="col-sm-0 col-md-1"></div>
            <div class="col-sm-12 col-md-10">
                <br>
                <div id="alert"></div>
            </div>
            <div class="col-sm-0 col-md-1"></div>
        </div>
    </div>

    <script type="text/javascript">
        function showAlert(message, alertType = "success", closeButton = true, title = "") {
            if(!title) {
                switch (alertType) {
                    case 'success':
                        title = "Mensaje";
                        break;
                    case 'warning':
                        title = "Advertencia";
                        break;
                    case 'danger':
                        title = "Error";
                        break;
                }
            }

            closeButton = closeButton ? `                    
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>` : '';

            $("#alert").html(`
                <div class="alert alert-${ alertType }" role="alert">${ closeButton }
                    <h4 class="alert-heading">${ title }</h4>
                    <hr/>${ message }
                </div>
            `);
        }
    </script>
</body>