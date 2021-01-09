<?php
require_once("php/class/User.class.php");
require_once("php/class/Order.class.php");
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item <?php echo $current_page == 'index' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=index">Inicio</a>
            </li>
            <li class="nav-item <?php echo $current_page == 'releases' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=releases">Próximos artículos</a>
            </li>
            <li class="nav-item <?php echo $current_page == 'offers' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=offers">Ofertas</a>
            </li>
            <li class="nav-item dropdown <?php echo $current_page == 'shipping/shippingOptions' || $current_page == 'shipping/terms' || 
                                                    $current_page == 'shipping/returnPolitics'  || $current_page == 'shipping/warranty'  ? 'active' : ''; ?>">
                <a class="nav-link dropdown-toggle" href="#" id="shipping" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Envíos
                </a>
                <div class="dropdown-menu" aria-labelledby="shipping">
                    <a class="dropdown-item" href="?page=shipping/shippingOptions">Formas de envío</a>
                    <a class="dropdown-item" href="?page=shipping/terms">Condiciones</a>
                    <a class="dropdown-item" href="?page=shipping/returnPolitics">Políticas de devolución</a>
                    <a class="dropdown-item" href="?page=shipping/warranty">Garantía</a>
                </div>
            </li>
            <li class="nav-item <?php echo $current_page == 'about' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=about">Quienes somos</a>
            </li>
            <li class="nav-item <?php echo $current_page == 'contact' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=contact">Contacto</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar artículo" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-shopping-cart"></i>
                    <?php
                    if($order && count($order->getOrderLines()) > 0) {
                        echo "Mi carrito (<span  id='shoppingCartQuantity' style='color:red;'>" . $order->getTotalQuantity() . "</span>)";
                    } else {
                        echo "Mi carrito <span>(0)</span>";
                    }
                    ?>
                </a>
                <div class="dropdown-menu">
                    <?php
                        if($order && count($order->getOrderLines()) > 0) {
                            foreach ($order->getOrderLines() as $index => $orderLine) {
                                echo "<a class='dropdown-item' href='#'>" . substr($orderLine->getArticleName(), 0, 25) . " - " .  $orderLine->getPrice() . "€</a>";
                            }
                            echo "<div class='dropdown-divider'></div>";
                            echo "<a class='dropdown-item' href='#'><b>Total (" . $order->getTotalQuantity() . "): " . $order->getTotalPrice() . "€</b></a>";
                        } else {
                            echo "<a class='dropdown-item' href='#'>No hay artículos</a>";
                        }
                    ?>
                    <div class='dropdown-divider'></div>
                    <center>
                        <a class='btn btn-secondary' href='?page=shoppingCart' role='button' style='width: 90%;'>
                            <i class='fas fa-cart-arrow-down'></i>&nbspVer carrito
                        </a>
                    </center>
                </div>
            </li>

            <?php
            ;
            $current_session = getLogged();
            if(!$current_session) {
            ?>
            <li class="nav-item" style="margin-right:50px;">
                <a class="nav-link" href="?page=login">
                    <i class="fas fa-user"></i>
                    Ingresar
                </a>
            </li>
            <?php
            } else {
            ?>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <?php echo $current_session["email"]; ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?page=private/my-account/my-account">Mi cuenta</a>
                        <a class="dropdown-item" href="?page=private/my-orders/my-orders">Mis pedidos</a>
                        <?php
                            if(User::isEmployment() || User::isAdmin()) {
                                echo "<a class='dropdown-item' href='?page=private/reports/index'>Informes</a>";
                            }
                            if(User::isAdmin()) {
                                echo "<a class='dropdown-item' href='?page=private/admin/index'>Administración</a>";
                            }
                        ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="php/security/logout.php"><b>Cerrar sesión</a>
                    </div>
                </li>
            </ul>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>